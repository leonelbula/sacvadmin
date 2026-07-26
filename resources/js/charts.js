import Chart from "chart.js/auto";

const canvas = document.getElementById("salesChart");

if (canvas) {
    new Chart(canvas, {
        type: "line",

        data: {
            labels: [
                "Ene",
                "Feb",
                "Mar",
                "Abr",
                "May",
                "Jun",
                "Jul",
                "Ago",
                "Sep",
                "Oct",
                "Nov",
                "Dic",
            ],

            datasets: [
                {
                    label: "Ventas",

                    data: [12, 18, 14, 22, 26, 31, 29, 35, 38, 41, 46, 55],

                    borderColor: "#2563EB",

                    backgroundColor: "rgba(37,99,235,.12)",

                    fill: true,

                    tension: 0.4,

                    pointRadius: 5,
                },
            ],
        },

        options: {
            responsive: true,

            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    });
}
