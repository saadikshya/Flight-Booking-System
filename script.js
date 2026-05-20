function addHomeDetails() {
    let homeContent = document.getElementById("home-content");

    
    if (homeContent.innerHTML === "") {
        homeContent.innerHTML = `
            <p>Discover amazing destinations and book flights with ease.</p>
            <ul>
                <li>✔ Exclusive flight deals</li>
                <li>✔ 24/7 customer support</li>
                <li>✔ Easy and secure booking</li>
            </ul>
        `;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    fetch("fetch_flights.php")
        .then(response => response.json())  
        .then(data => {
            let flightTable = document.getElementById("flights-list");
            flightTable.innerHTML = ""; 

            data.forEach(flight => {
                let row = `
                    <tr>
                        <td>${flight.flight_no}</td>
                        <td>${flight.departure}</td>
                        <td>${flight.destination}</td>
                        <td>${flight.price}</td>
                    </tr>
                `;
                flightTable.innerHTML += row; 
            });
        })
        .catch(error => console.log("Error fetching flights:", error));
});

document.getElementById("flight-form").addEventListener("submit", function (event) {
    event.preventDefault(); 

    let formData = new FormData();
    formData.append("flight_no", document.getElementById("flight_no").value);
    formData.append("departure", document.getElementById("departure").value);
    formData.append("destination", document.getElementById("destination").value);
    formData.append("price", document.getElementById("price").value);

    fetch("add_flight.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); 
        if (data.status === "success") {
            document.getElementById("flight-form").reset(); 
            location.reload(); 
        }
    })
    .catch(error => console.error("Error:", error));
});




