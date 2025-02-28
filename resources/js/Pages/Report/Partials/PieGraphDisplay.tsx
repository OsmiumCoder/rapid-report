

import Chart from 'chart.js/auto';
import { CategoryScale } from "chart.js";
import { useState } from "react";
import { Pie } from "react-chartjs-2";

Chart.register(CategoryScale);


export interface PieGraphDataProps {
    labels: string[];
    entries: number[];
    entries_number: number;
    title: string;
    description: string;
}
export default function PieGraphDisplay({labels,entries,entries_number, title, description}: PieGraphDataProps) {
    const color = ['#7c2d1c','#7fa33f','#fcd177', '#4e0f10','#5c8727','#fbb040', '#1a0604','#1f3912','#a76119'];
    const [data, setData] = useState({
        labels: labels,
        datasets: [{
            label: title,
            data: entries,
            backgroundColor: color.slice(0,entries_number),
            hoverOffset: 10
        }]
    });

    return (
        <div className="overflow-hidden rounded-lg bg-gray-800 ring-1 ring-white/15 max-lg:rounded lg:rounded">
            <Pie
                data={data}
                options={{
                    plugins: {
                        title: {
                            display: true,
                            text: data.datasets[0].label,
                        },
                    },
                }}
            />
            <div className="p-10">
                <h3 className="text-sm/4 font-semibold text-gray-400">{description}</h3>
            </div>
        </div>
    );

}
