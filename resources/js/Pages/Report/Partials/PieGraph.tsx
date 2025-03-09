import { GraphFooter } from '@/Pages/Report/Partials/GraphFooter';
import { ChartData } from 'chart.js';
import { Pie } from 'react-chartjs-2';

interface pieProps {
    graphKey: number;
    data: ChartData<'pie'>;
}
export default function PieGraph({ graphKey, data }: pieProps) {
    return (
        <Pie
            key={graphKey}
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
                            footer: GraphFooter,
                        },
                    },
                },
            }}
        />
    );
}
