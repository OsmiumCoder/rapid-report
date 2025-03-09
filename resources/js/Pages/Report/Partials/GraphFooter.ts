import { ChartTypeRegistry, TooltipItem } from 'chart.js';

export const GraphFooter = (ctx: TooltipItem<keyof ChartTypeRegistry>[]) => {
    let sum = 0;
    for (let item = 0; item < ctx[0].dataset.data.length; item = item + 1) {
        if (ctx[0].dataset.data[item] != null) {
            sum += +(ctx[0].dataset.data[item] ?? 0);
        }
    }
    const percent = Math.round(sum == 0 ? 100 : (+ctx[0].formattedValue / sum) * 10000) / 100;
    return percent + '%';
};
