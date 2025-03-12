import { getPercent } from '@/Helpers/Report/getPercent';
import { ChartData } from 'chart.js';
import { Pie } from 'react-chartjs-2';

interface PieProps {
    data: ChartData<'pie'>;
}
export default function PieGraph({ data }: PieProps) {
    return (
        <Pie
            data={data}
            options={{
                plugins: {
                    legend: {
                        labels: {
                            color: 'gray-900',
                            font: {
                                size: 16,
                            },
                            padding: 20,
                            boxWidth: 20,
                            boxHeight: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
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
                    tooltip: {
                        callbacks: {
                            footer: getPercent,
                        },
                    },
                },
            }}
        />
    );
}
