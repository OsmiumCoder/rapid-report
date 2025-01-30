import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

function Index() {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Reports Index
                </h2>
            }
        >
        </AuthenticatedLayout>
    );
}
