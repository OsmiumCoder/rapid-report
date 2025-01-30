import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

function Show() {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Reports Show
                </h2>
            }
        >
        </AuthenticatedLayout>
    );
}
