import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react';
import { CategoryScale, ChartData } from 'chart.js';
import Chart from 'chart.js/auto';
import { ChartBar, ChartPie, EditIcon } from 'lucide-react';
import { useState } from 'react';
import PieGraph from '@/Pages/Report/Partials/PieGraph';
import BarGraph from '@/Pages/Report/Partials/BarGraph';
Chart.register(CategoryScale);

export interface GraphProps {
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
export default function Graph({
    labels,
    entries,
    entriesNumber,
    title,
    description,
    graphKey,
    otherItems,
    setNewItem,
    canEdit,
    isBarInit,
}: GraphProps) {
    const colors = ['#7c2d1c', '#7fa33f', '#fcd177', '#4e0f10', '#5c8727', '#fbb040', '#1a0604', '#1f3912', '#a76119'];
    const [isBar, setIsBar] = useState(isBarInit);
    const bar_data:ChartData<'bar'> = {
        labels: labels,
        datasets: [
            {
                label: title,
                data: entries,
                backgroundColor: colors.slice(0, entriesNumber),
            },
        ],
    };
    const pie_data:ChartData<'pie'> = {
        labels: labels,
        datasets: [
            {
                label: title,
                data: entries,
                backgroundColor: colors.slice(0, entriesNumber),
                hoverOffset: 10,
            },
        ],
    };
    return (
        <div className="overflow-hidden rounded-lg bg-white ring-1 ring-white/15 max-lg:rounded lg:rounded">
            <div className="absolute top-0 left-0 mt-2 ml-2 flex">
                <button
                    className={
                        'focus-visible:outline-upei-green-600 rounded-full p-1 hover:bg-gray-200 focus-visible:outline-2 focus-visible:outline-offset-2'
                    }
                    onClick={() => setIsBar((prev) => !prev)}
                >
                    {isBar ? <ChartPie /> : <ChartBar />}
                </button>
            </div>
            <div className="absolute top-0 right-0 mr-2">
                {canEdit ? (
                    <>
                        <Menu>
                            <MenuButton
                                type="button"
                                className="focus-visible:outline-upei-green-600 mt-3 ml-5 rounded-full bg-white p-1 text-white shadow-xs hover:bg-gray-200 focus-visible:outline-2 focus-visible:outline-offset-2"
                            >
                                <EditIcon aria-hidden="true" className="size-5" stroke={'#000000'} />
                            </MenuButton>
                            <MenuItems
                                transition
                                className="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 transition focus:outline-hidden data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in"
                            >
                                <div className="py-1">
                                    {otherItems.map((item, index) => (
                                        <MenuItem key={index}>
                                            <a
                                                onClick={() => setNewItem(graphKey, index)}
                                                className="block px-4 py-2 text-sm text-gray-700 data-focus:bg-gray-100 data-focus:text-gray-900 data-focus:outline-hidden"
                                            >
                                                {item}
                                            </a>
                                        </MenuItem>
                                    ))}
                                </div>
                            </MenuItems>
                        </Menu>
                    </>
                ) : (
                    <></>
                )}
            </div>
            {isBar ? (
                <BarGraph
                    graphKey={graphKey}
                    data={bar_data}
                />
            ) : (
                <PieGraph
                    graphKey={graphKey}
                    data={pie_data}
                />
            )}
            <div className="flex justify-center p-5 text-gray-900">
                <h3 className="text-sm/4 font-semibold">{description}</h3>
            </div>
        </div>
    );
}
