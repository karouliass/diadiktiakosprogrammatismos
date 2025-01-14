export function validateForm() {
    const title = document.getElementById("title").value.trim();
    const year = document.getElementById("year").value;
    const copies = document.getElementById("copies").value;
    const categories = document.getElementById("categories").selectedOptions;

    let errors = [];

    if (!title) errors.push("Title is required.");
    if (!description) errors.push("Description is missing."); 
    if (year < 1900 || year > 2024) errors.push("Year must be between 1900 and 2024.");
    if (copies <= 0) errors.push("Number of copies must be greater than 0.");
    if (categories.length < 1) {
        errors.push("At least one category must be selected.");
    } else if (categories.length > 3) {
        errors.push("You can select up to 3 categories.");
    }

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

  // Disable the year input when "Unknown" is selected in the condition dropdown
  function handleConditionChange() {
    const condition = document.getElementById("condition").value;
    const yearField = document.getElementById("year");
    yearField.disabled = (condition === "Unknown");
    
    // Optionally, clear the year field if it's disabled
    if (yearField.disabled) {
        yearField.value = "";
    }
}

// Initialize the year field on page load, in case "Unknown" is preselected
window.onload = function() {
    handleConditionChange();
};