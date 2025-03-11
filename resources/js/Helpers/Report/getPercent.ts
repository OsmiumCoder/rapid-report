import { ChartTypeRegistry, TooltipItem } from 'chart.js';

export const getPercent = (ctx: TooltipItem<keyof ChartTypeRegistry>[]) => {
    const sum = ctx[0].dataset.data.reduce<number>((sum, item) => (item !== null ? sum + +(item ?? 0) : sum), 0);
    const percent = Math.round(sum == 0 ? 100 : (+ctx[0].formattedValue / sum) * 10000) / 100;

    return percent + '%';
};
