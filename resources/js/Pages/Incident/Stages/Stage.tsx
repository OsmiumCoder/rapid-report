import { PropsWithChildren } from "react";
import ProgressBarsCircle from "@/Components/ProgressBarsCircle";

interface isStage extends PropsWithChildren{
    boolHandle: Function, dataHandle: Function, currentData: {}
}

export default function Stage(props: { s_amount: number, current_s: number, children: isStage }) {
    const s_amount = props.s_amount;
    const current_s = props.current_s;
    const progress_arr = (new Array(current_s).fill("complete")).concat(["current"]).concat(new Array(s_amount - current_s).fill("upcoming"))
    let steps = [];
    const step = { name: "", status: "" };
    let i = 0
    while (i < s_amount) {
        steps.push(structuredClone(step))
        steps[i].name = "Step" + i.toString();
        steps[i].status = progress_arr[i];
        console.log(steps[0]);
        i++;
    }
    console.log(steps);
    
    return (
        <>
            <div className="flex justify-center">
            <ProgressBarsCircle
                steps={steps} className="relative flex gap-3">
            </ProgressBarsCircle>
        </div>
        <div className="relative flex gap-3 pb-4 pt-3.5 mt-4">
                {props.children}
        </div>
        </>
        );
        

}
