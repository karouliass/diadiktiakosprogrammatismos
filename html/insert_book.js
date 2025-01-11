export function validateForm() {
    const title = document.getElementById("title").value.trim();
    const year = document.getElementById("year").value;
    const copies = document.getElementById("copies").value;
    const categories = document.getElementById("categories").selectedOptions;

    let errors = [];

    if (!title) errors.push("Title is required.");
    if (year < 1900 || year > 2024) errors.push("Year must be between 1900 and 2024.");
    if (copies <= 0) errors.push("Number of copies must be greater than 0.");
    if (categories.length === 0) errors.push("At least one category must be selected.");

    if (errors.length > 0) {
        alert(errors.join("\n"));
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}

export function clearForm() {
    document.getElementById("insertBookForm").reset();
    document.getElementById("categories").selectedIndex = -1; // Deselect categories
}

function handleConditionChange() {
    const condition = document.getElementById("condition").value;
    const yearField = document.getElementById("year");
    yearField.disabled = (condition === "Unknown");
}
