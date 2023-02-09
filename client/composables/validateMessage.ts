const nameOfAttribute = {
    name: "Name",
    email: "Email",
    password: "Password",
    password_confirmation: "Confirm Password",
    phone_number: "Phone Number",
    address: "Address",
};

export function getErrorMessage(errors: any) {
    errors = errors.response.data.errors;
    return errors[Object.keys(errors)[0]][0];
}

export function requiredMessage(fieldName: string) {
    return `${fieldName} is required`;
}

export function validateRequired(obj: Object) {
    for (let key in obj) {
        // @ts-ignore
        if (obj[key] == null || obj[key] == "")
            { // @ts-ignore
                return requiredMessage(nameOfAttribute[key]);
            }
    }
    return null;
}