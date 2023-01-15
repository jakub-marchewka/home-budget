import {Chart} from "chart.js/auto";
export class PropertyChart
{
    constructor()
    {
        const ctx = document.getElementById('myChart');
        let data = $('#myChart').attr('data-set');
        data = $.parseJSON(data)
        console.log(data.dataSets);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Suma',
                    data: data.dataSets,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
}