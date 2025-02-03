import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import React, { FormEvent } from 'react';
import {useForm} from "@inertiajs/react";
import IncidentData from "@/types/incident/IncidentData";

export default function Create() {
    const { data, setData, post } = useForm();

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        console.log(data);
    };

    return (
        <AuthenticatedLayout>
            <div style={{ maxWidth: '400px', margin: '50px auto', padding: '20px', fontFamily: 'Arial, sans-serif' }}>
                <h1 style={{ textAlign: 'center' }}>Create Investigation</h1>
                <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '15px' }}>

                    <button
                        type="submit"
                        style={{
                            backgroundColor: '#4CAF50',
                            color: 'white',
                            padding: '10px 20px',
                            border: 'none',
                            borderRadius: '4px',
                            cursor: 'pointer'
                        }}
                    >
                        Submit
                    </button>
                </form>
            </div>
        </AuthenticatedLayout>

    );
};

