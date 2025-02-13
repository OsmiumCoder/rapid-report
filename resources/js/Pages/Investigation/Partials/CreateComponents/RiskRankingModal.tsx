import Modal from '@/Components/Modal';
import React, { Dispatch, SetStateAction } from 'react';

interface RiskRankingModalProps {
    isOpen: boolean;
    setIsOpen: Dispatch<SetStateAction<boolean>>;
}
export default function RiskRankingModal({ isOpen, setIsOpen }: RiskRankingModalProps) {
    return (
        <Modal show={isOpen} onClose={() => setIsOpen(false)} maxWidth={'4xl'}>
            <div className="p-4 flex flex-col justify-center text-center">
                <h3 className="text-lg font-bold mb-2">
                    Three Point Risk Ranking Scheme and Ranking Matrix
                </h3>

                <table className="border border-gray-300 text-lg">
                    <thead>
                        <tr>
                            <th rowSpan={2} className="border border-gray-300 px-4 py-2">
                                Frequency
                            </th>
                            <th colSpan={3} className="border border-gray-300 px-4 py-2">
                                Hazard Severity
                            </th>
                        </tr>
                        <tr>
                            <th className="border border-gray-300 px-4 py-2">Minor</th>
                            <th className="border border-gray-300 px-4 py-2">Serious</th>
                            <th className="border border-gray-300 px-4 py-2">Major</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td className="border border-gray-300 px-4 py-2">Seldom</td>
                            <td className="border-r border-b border-black px-4 py-2 bg-green-300">
                                1
                            </td>
                            <td className="border-x border-b border-black px-4 py-2 bg-green-300">
                                2
                            </td>
                            <td className="border-l border-b border-black px-4 py-2 bg-yellow-200">
                                3
                            </td>
                        </tr>
                        <tr>
                            <td className="border border-gray-300 px-4 py-2">Occasional</td>
                            <td className="border-y border-r border-black px-4 py-2 bg-green-300">
                                2
                            </td>
                            <td className="border border-black px-4 py-2 bg-yellow-200">4</td>
                            <td className="border-y border-l border-black px-4 py-2 bg-red-300">
                                6
                            </td>
                        </tr>
                        <tr>
                            <td className="border border-gray-300 px-4 py-2">Frequent</td>
                            <td className="border-t border-r border-black px-4 py-2 bg-yellow-200">
                                3
                            </td>
                            <td className="border-t border-x border-black px-4 py-2 bg-red-300">
                                6
                            </td>
                            <td className="border-t border-l border-black px-4 py-2 bg-red-300">
                                9
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div className="flex justify-between mt-6 gap-4">
                    <table className="border border-gray-300 w-1/2">
                        <thead>
                            <tr>
                                <th colSpan={2} className="border border-gray-300 px-4 py-2">
                                    Hazard Severity Potential
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td className="border border-gray-300 px-4 py-2">
                                    <strong>Minor</strong>
                                </td>
                                <td className="border border-gray-300 px-4 py-2">
                                    Low risk to students/staff/visitors/contractors/UPEI
                                </td>
                            </tr>
                            <tr>
                                <td className="border border-gray-300 px-4 py-2">
                                    <strong>Serious</strong>
                                </td>
                                <td className="border border-gray-300 px-4 py-2">
                                    Moderate risk to students/staff/ visitors/contractors/UPEI
                                </td>
                            </tr>
                            <tr>
                                <td className="border border-gray-300 px-4 py-2">
                                    <strong>Major</strong>
                                </td>
                                <td className="border border-gray-300 px-4 py-2">
                                    High risk to students/staff/visitors/contractors/UPEI
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table className="border border-gray-300 w-1/2">
                        <thead>
                            <tr>
                                <th colSpan={2} className="border border-gray-300 px-4 py-2">
                                    Frequency / Probability of Occurrence
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td className="border border-gray-300 px-4 py-2 ">
                                    <strong>Seldom</strong>
                                </td>
                                <td className="border border-gray-300 px-4 py-2">
                                    Very unlikely risk to students/staff/visitors/contractors/UPEI
                                </td>
                            </tr>
                            <tr>
                                <td className="border border-gray-300 px-4 py-2 text-center">
                                    <strong>Occasional</strong>
                                </td>
                                <td className="border border-gray-300 px-4 py-2">
                                    Risk to some students/staff/visitors/contractors during specific
                                    tasks or areas. Medium risk to UPEI
                                </td>
                            </tr>
                            <tr>
                                <td className="border border-gray-300 px-4 py-2 text-center">
                                    <strong>Frequent</strong>
                                </td>
                                <td className="border border-gray-300 px-4 py-2">
                                    Students/staff/visitors/contractors/UPEI continuously exposed to
                                    the risk
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </Modal>
    );
}
