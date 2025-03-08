import { Bar } from 'react-chartjs-2';
import { GraphFooter } from '@/Pages/Report/Partials/GraphFooter';
import { ChartData } from 'chart.js';

interface barProps{
    graphKey: number,
    data:ChartData<'bar'>
}
export default function BarGraph({ graphKey, data}:barProps){
    return(<Bar
        key={graphKey}
        data={data}
        options={{
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        footer: GraphFooter,
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
    />);
}
