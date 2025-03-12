import { getPercent } from '@/Helpers/Report/getPercent';
import { ChartData } from 'chart.js';
import { Bar } from 'react-chartjs-2';

interface BarProps {
    data: ChartData<'bar'>;
}
export default function BarGraph({ data }: BarProps) {
    return (
        <Bar
            data={data}
            options={{
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            footer: getPercent,
                        },
                    },
                    title: {
                        display: true,
                        text: data.datasets[0].label,
                        color: 'gray-900',
                        font: {
                            size: 20,
                        },
                    },
                },
            }}
        />
    );
}
