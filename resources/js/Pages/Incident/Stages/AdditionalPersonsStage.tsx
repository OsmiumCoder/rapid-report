import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import React, { useState } from 'react';
import AdditionalPerson from "@/types/AdditionalPerson";
import { PlusIcon} from '@heroicons/react/20/solid'
import ReportPersonList from "@/Components/ReportPersonList";

export default function AdditionalPersonsStage({
    formData,
    setFormData
}: StageProps) {
    class Witness implements AdditionalPerson{
        email: string = "";
        index: number =0;
        info: string = "";
        phone: string = "";
        name: string = "";

    }
    function validatePhoneInput(value: string) {
        value = value.replace(/[^0-9-]/g, '');

        if (value.length > 3 && value[3] !== '-') {
            value = value.slice(0, 3) + '-' + value.slice(3);
        }
        if (value.length > 7 && value[7] !== '-') {
            value = value.slice(0, 7) + '-' + value.slice(7);
        }
        return value.slice(0, 12); // Enforce max length
    }
    const [personData, setPersonData] = useState<Array<AdditionalPerson>>(formData.witnesses);
    const [personDataLength, setPersonDataLength] = useState(0);
    const [personInProgress, setPersonInProgress] = useState(new Witness())
    const [validationError, setValidationError] = useState(false)
    const [formVisible, setFormVisible] = useState(false)
    const handlePersonAdd = () => {
        if(personInProgress.name === "" || (personInProgress.phone === "" && personInProgress.email === "")){
            setValidationError(true);
        }else{
            setValidationError(false);
            setPersonData([...personData, personInProgress]);
            setFormData( prevState => ({
                    ...prevState,
                    witnesses: [...formData.witnesses, personInProgress]
            }));
            setPersonInProgress(new Witness());
            setPersonDataLength(personDataLength + 1);
            setPersonInProgress((prev) => ({
                ...prev,
                index: personDataLength
            }));
            setFormVisible(!formVisible);
        }
    }
const handPersonRemove = (index: number) => {
        setFormData(prev => ({
          ...prev,
          witnesses: formData.witnesses.filter((person) => (person.index!=index))
        }))
        console.log(index)

}
    return (<>
        <div className="min-w-0 flex-1 text-sm/6 space-y-4">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Witnesses
            </label>

        {formVisible && ( <><div>
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Witness Name
                    </label>
                    <div className="mt-2">
                        <input
                            value = {personInProgress.name}
                            onChange = {(e) => {
                                setPersonInProgress((prev) => ({
                                    ...prev,
                                    name: e.target.value,
                                }))
                            }}
                            className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Witness Email
                    </label>
                    <div className="mt-2">
                        <input
                            type="email"
                            value = {personInProgress.email}
                            onChange = {(e) => {
                                setPersonInProgress((prev) => ({
                                    ...prev,
                                    email: e.target.value,
                                }))
                            }}
                            placeholder="you@example.com"
                            className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>
                <div className="mt-2">
                    <div>
                        <label className="block text-sm/6 font-medium text-gray-900">
                            Phone Number
                        </label>
                    </div>

                    <div className="mt-1">
                        <input
                            required
                            type="tel"
                            placeholder="123-456-7890"
                            value={personInProgress.phone ?? ''}
                            onChange={(e) =>
                                setPersonInProgress((prev) => ({
                                    ...prev,
                                    phone: validatePhoneInput(
                                        e.target.value
                                    ),
                                }))
                            }
                            className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>


            </div>
            <div
            className="flex-1 justify-self-center"
            >
                <button
                    type="button"
                    onClick= {() => {setFormVisible(!formVisible)}}
                    className="mr-16 pr-3 items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Cancel
                </button>
            <button
            type="button"
            onClick={handlePersonAdd}
            className="items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Add Witness
            </button>

            </div>
                {validationError && (
                    <p id="email-error" className="mt-2 text-sm text-red-600">
                    *More Information required<br />
                    *Name and either Phone number or email required
                    </p>

                )}

            </>

        )}
        {!formVisible && (
            <>
            <ReportPersonList removeFunction={handPersonRemove} additionalPeople={formData.witnesses}/>
            <div
                className="flex justify-center">
            <button
                type="button"
                onClick={() => {setFormVisible(!formVisible)}}
                className="flex justify-center items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Add a Witness
                <PlusIcon aria-hidden="true" className="size-3" />

            </button>
            </div>
            </>
        )}
        </div>
    </>);



}
