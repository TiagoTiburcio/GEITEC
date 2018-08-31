/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *  @author Tiago Tiburcio
 */

let primeiroGrafico = document.getElementById('primeiroGrafico').getContext('2d');

let chart = new Chart(primeiroGrafico, {
    type: 'line',

    data: {
        labels: ['2000', '2001', '2002', '2003', '2004', '2009'],

        datasets: [{
                label: 'Crecimento Populacional',
                data: [173448346, 175885229, 178276128, 180619108, 182911487, 185150806],
                backgroundColor: "rgba(255, 34, 0, 0.3)",
                borderColor: "#0000ff"
            },
            {
                label: 'Exemplo de Gráfico Comparativo',
                data: [173448346, 185150806, 175885229, 182911487, 178276128, 180619108],
                backgroundColor: "rgba(0, 255, 0, 0.3)",
                borderColor: "#002200"
            }
        ]
    }

});

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        datasets: [
            {label: "Red",
                data: [1],
                backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(255,99,132,1)'],
                borderWidth: 1
            },
            {label: "Blue",
                data: [2],
                backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)'],
                borderWidth: 1
            },
            {label: "Yellow",
                data: [3],
                backgroundColor: ['rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }, {
                label: "Green",
                data: [4],
                backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }, {
                label: "Purple",
                data: [5],
                backgroundColor: ['rgba(153, 102, 255, 0.2)'],
                borderColor: ['rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }, {
                label: "Orange",
                data: [6],
                backgroundColor: ['rgba(255, 159, 64, 0.2)'],
                borderColor: ['rgba(255, 159, 64, 1)'],
                borderWidth: 1
            }]
    },
    options: {
        scales: {
            yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
        }
    }
});

