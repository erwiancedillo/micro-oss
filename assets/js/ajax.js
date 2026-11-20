let centers = [];

function loadCenters() {

    fetch("api/get-centers.php")
        .then(response => response.json())
        .then(data => {

            centers = data;

            data.forEach(center => {

                const icon = L.divIcon({ className: 'center-map-marker', html: '<span style="display:block;width:18px;height:18px;border:2px solid #fff;border-radius:50%;background:#dc2626"></span>', iconSize: [18, 18], iconAnchor: [9, 9] });
                L.marker([parseFloat(center.latitude), parseFloat(center.longitude)], { title: center.name, icon }).addTo(map);

            });

        })
        .catch(error => {
            console.error("Error loading centers:", error);
        });
}