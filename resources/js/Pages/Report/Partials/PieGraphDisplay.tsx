

import Chart, { ChartTypeRegistry, TooltipItem } from 'chart.js/auto';
import { CategoryScale } from "chart.js";
import { Bar, Pie } from 'react-chartjs-2';
import { ChartBar, ChartPie, EditIcon } from 'lucide-react';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react';
import { useState } from 'react';
Chart.register(CategoryScale);


export interface PieGraphDataProps {
    labels: string[];
    entries: number[];
    entriesNumber: number;
    title: string;
    description: string;
    graphKey: number;
    otherItems: string[];
    setNewItem: (key: number, item: number) => void;
    canEdit: boolean;
    isBarInit: boolean;
}
export default function PieGraphDisplay({labels,entries,entriesNumber, title, description, graphKey, otherItems,setNewItem, canEdit, isBarInit}: PieGraphDataProps) {
    //useEffect(() => {console.log(graph_key)})
    const color = ['#7c2d1c','#7fa33f','#fcd177', '#4e0f10','#5c8727','#fbb040', '#1a0604','#1f3912','#a76119'];
    const [isBar, setIsBar] = useState(isBarInit);
    const data = {
        labels: labels,
        datasets: [{
            label: title,
            data: entries,
            backgroundColor: color.slice(0,entriesNumber),
            hoverOffset: 10
        }]
    };

    const footer = (ctx: TooltipItem<keyof ChartTypeRegistry>[]) => {
        let sum = 0;
        for (let item = 0; item < ctx[0].dataset.data.length; item = item + 1) {
            if (ctx[0].dataset.data[item] != null) {
                // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                // @ts-expect-error
                sum += +ctx[0].dataset.data[item];
            }
        }
        const percent = Math.round(sum == 0 ? 100 : (+ctx[0].formattedValue / sum) * 10000) / 100;
        return '' + percent + '%';
    };
    return (
        <div className="overflow-hidden rounded-lg bg-white ring-1 ring-white/15 max-lg:rounded lg:rounded">
            <div className="absolute flex top-0 left-0 mt-2 ml-2">
               <button
                   className={"rounded-full p-1 hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"}
                    onClick={() => setIsBar((prev)=> !prev)}
               >
                   {isBar ? <ChartPie/>: <ChartBar/>}
               </button>
            </div>
            <div className="absolute top-0 right-0 mr-2">
                {canEdit ? <>
                    <Menu>
                        <MenuButton
                            type="button"
                            className="rounded-full bg-white p-1 mt-3 ml-5 text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            <EditIcon aria-hidden="true" className="size-5" stroke={'#000000'} />
                        </MenuButton>
                        <MenuItems
                            transition
                            className="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 transition focus:outline-hidden data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in"
                        >
                            <div className="py-1">
                                {otherItems.map((item, index) =>
                                    <MenuItem key={index}>
                                        <a
                                            onClick={() => setNewItem(graphKey,index)}
                                            className="block px-4 py-2 text-sm text-gray-700 data-focus:bg-gray-100 data-focus:text-gray-900 data-focus:outline-hidden"
                                        >
                                            {item}
                                        </a>
                                    </MenuItem>
                                )}
                            </div>
                        </MenuItems>
                    </Menu>
                    </>: <></>

                }
            </div>
            {isBar ?
            <Bar
                key={graphKey}
                data={data}
                options={{
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip:{
                            callbacks: {
                                footer: footer,
                            }
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
            /> :
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
                            }
                        },
                        title: {
                            display: true,
                            text: data.datasets[0].label,
                            color: 'gray-900',
                            font: {
                                size: 20,
                            },
                        },
                        tooltip:{
                            callbacks: {
                                footer: footer,
                            }
                        },
                    },
                }}
            />
            }
            <div className="flex p-5 justify-center text-gray-900">
                <h3 className="text-sm/4 font-semibold">{description}</h3>


            </div>

        </div>
    );

}
