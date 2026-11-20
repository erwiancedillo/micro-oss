(function () {
    const routingBase = 'https://router.project-osrm.org/route/v1/driving';
    const geocodingBase = 'https://nominatim.openstreetmap.org/reverse';
    let lastGeocodeAt = 0;
    let geocodeTimer = null;
    let geocodeController = null;
    let geocodeRequestId = 0;
    let pendingGeocodeReject = null;

    function addressComponents(address = {}) {
        const components = [];
        const add = (value, ...types) => {
            if (value) components.push({ long_name: value, short_name: value, types });
        };

        add(address.neighbourhood || address.suburb || address.quarter || address.city_district, 'neighborhood', 'sublocality', 'sublocality_level_1', 'political');
        add(address.village || address.town || address.city || address.municipality, 'locality', 'administrative_area_level_3', 'political');
        add(address.road || address.pedestrian || address.footway, 'route');
        add(address.county, 'administrative_area_level_2', 'political');
        add(address.state, 'administrative_area_level_1', 'political');
        return components;
    }

    window.mapServices = {
        async reverseGeocode(lat, lng) {
            const url = new URL(geocodingBase);
            url.search = new URLSearchParams({ format: 'jsonv2', lat: String(lat), lon: String(lng), addressdetails: '1' });
            const requestId = ++geocodeRequestId;
            if (geocodeTimer) {
                clearTimeout(geocodeTimer);
                geocodeTimer = null;
                if (pendingGeocodeReject) pendingGeocodeReject(new DOMException('Superseded geocoding request', 'AbortError'));
                pendingGeocodeReject = null;
            }
            if (geocodeController) geocodeController.abort();

            return new Promise((resolve, reject) => {
                pendingGeocodeReject = reject;
                const wait = Math.max(0, 1100 - (Date.now() - lastGeocodeAt));
                geocodeTimer = setTimeout(async () => {
                    geocodeTimer = null;
                    pendingGeocodeReject = null;
                    geocodeController = new AbortController();
                    lastGeocodeAt = Date.now();
                    try {
                        const response = await fetch(url, { signal: geocodeController.signal });
                        if (!response.ok) throw new Error(`Reverse geocoding failed (${response.status})`);
                        const result = await response.json();
                        if (requestId !== geocodeRequestId) return reject(new DOMException('Superseded geocoding request', 'AbortError'));
                        resolve({ formatted_address: result.display_name || '', address_components: addressComponents(result.address) });
                    } catch (error) {
                        reject(error);
                    }
                }, wait);
            });
        },

        async route(start, destination) {
            const coordinates = `${start.lng},${start.lat};${destination.lng},${destination.lat}`;
            const response = await fetch(`${routingBase}/${coordinates}?overview=full&geometries=geojson`);
            if (!response.ok) throw new Error(`Routing failed (${response.status})`);
            const result = await response.json();
            if (result.code !== 'Ok' || !result.routes?.length) throw new Error(result.message || 'No route found');
            const route = result.routes[0];
            return {
                distance: route.distance,
                duration: route.duration,
                coordinates: route.geometry.coordinates.map(([lng, lat]) => [lat, lng]),
                distanceText: route.distance >= 1000 ? `${(route.distance / 1000).toFixed(2)} km` : `${Math.round(route.distance)} m`,
                durationText: `${Math.max(1, Math.round(route.duration / 60))} min`
            };
        }
    };

    window.addLeafletFullscreenControl = function (map) {
        const control = L.control({ position: 'topleft' });
        control.onAdd = function () {
            const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
            const button = L.DomUtil.create('a', 'leaflet-fullscreen-control', container);
            button.href = '#';
            button.title = 'Toggle fullscreen map';
            button.setAttribute('role', 'button');
            button.setAttribute('aria-label', 'Toggle fullscreen map');
            button.innerHTML = '<span aria-hidden="true">⛶</span>';
            L.DomEvent.disableClickPropagation(container);
            L.DomEvent.on(button, 'click', function (event) {
                L.DomEvent.preventDefault(event);
                const target = map.getContainer();
                if (document.fullscreenElement === target) document.exitFullscreen?.();
                else target.requestFullscreen?.();
            });
            document.addEventListener('fullscreenchange', () => {
                if (document.fullscreenElement === map.getContainer()) button.classList.add('is-fullscreen');
                else button.classList.remove('is-fullscreen');
                map.invalidateSize();
            });
            return container;
        };
        control.addTo(map);
    };
})();
