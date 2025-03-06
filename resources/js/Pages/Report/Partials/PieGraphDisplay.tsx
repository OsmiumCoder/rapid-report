

import Chart from 'chart.js/auto';
import { CategoryScale } from "chart.js";
import { Pie } from "react-chartjs-2";
import { EditIcon } from 'lucide-react';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react';

Chart.register(CategoryScale);


export interface PieGraphDataProps {
    labels: string[];
    entries: number[];
    entries_number: number;
    title: string;
    description: string;
    graph_key: number;
    other_Items: string[];
    setnewItem: (key: number, item: number) => void;
}
export default function PieGraphDisplay({labels,entries,entries_number, title, description, graph_key, other_Items,setnewItem}: PieGraphDataProps) {
    //useEffect(() => {console.log(graph_key)})
    const color = ['#7c2d1c','#7fa33f','#fcd177', '#4e0f10','#5c8727','#fbb040', '#1a0604','#1f3912','#a76119'];
    const data = {
        labels: labels,
        datasets: [{
            label: title,
            data: entries,
            backgroundColor: color.slice(0,entries_number),
            hoverOffset: 10
        }]
    };

    return (
        <div className="overflow-hidden rounded-lg bg-gray-700 ring-1 ring-white/15 max-lg:rounded lg:rounded">
            <div className="absolute top-0 right-0 mt-2 mr-2">
                <Menu>
                    <MenuButton
                        type="button"
                        className="rounded-full bg-white p-1 mt-2 ml-5 text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        <EditIcon aria-hidden="true" className="size-5" stroke={'#000000'} />
                    </MenuButton>
                    <MenuItems
                        transition
                        className="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 transition focus:outline-hidden data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in"
                    >
                        <div className="py-1">
                            {other_Items.map((item, index) =>
                                <MenuItem key={index}>
                                    <a
                                        onClick={() => setnewItem(graph_key,index)}
                                        className="block px-4 py-2 text-sm text-gray-700 data-focus:bg-gray-100 data-focus:text-gray-900 data-focus:outline-hidden"
                                    >
                                        {item}
                                    </a>
                                </MenuItem>
                            )}
                        </div>
                    </MenuItems>
                </Menu>

            </div>

            <Pie
                data={data}
                options={{
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white',
                                font: {
                                    size: 16,
                                },
                                padding: 20,
                                boxWidth: 20,
                                boxHeight: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                            }
                        },
                        title: {
                            display: true,
                            text: data.datasets[0].label,
                            color: 'white',
                            font: {
                                size: 20,
                            },
                        },
                    },
                }}
            />
            <div className="flex p-5 justify-center">
                <h3 className="text-sm/4 font-semibold text-white">{description}</h3>


            </div>
        </div>
    );

}
