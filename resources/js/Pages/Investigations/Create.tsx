import React, { FormEvent } from 'react';

const Create: React.FC = () => {
    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const formData = new FormData(event.currentTarget);
        const data = {
            title: formData.get('title') as string,
            description: formData.get('description') as string,
        };

        console.log(data);
    };

    return (
        <div style={{ maxWidth: '400px', margin: '50px auto', padding: '20px', fontFamily: 'Arial, sans-serif' }}>
            <h1 style={{ textAlign: 'center' }}>Create Investigation</h1>
            <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '15px' }}>
                <div style={{ display: 'flex', flexDirection: 'column' }}>
                    <label htmlFor="title" style={{ marginBottom: '5px' }}>Title:</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        required
                        style={{ padding: '8px', border: '1px solid #ccc', borderRadius: '4px' }}
                    />
                </div>

                <div style={{ display: 'flex', flexDirection: 'column' }}>
                    <label htmlFor="description" style={{ marginBottom: '5px' }}>Description:</label>
                    <textarea
                        name="description"
                        id="description"
                        required
                        style={{ padding: '8px', border: '1px solid #ccc', borderRadius: '4px', minHeight: '100px' }}
                    ></textarea>
                </div>

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
    );
};

export default Create;
