let profileDropdownList = document.querySelector(".profile-dropdown-list");
let btn = document.querySelector(".profile-dropdown-btn");
/** 
let classList = profileDropdownList.classList;

Purpose: Stores the classList property of the profileDropdownList element in the variable classList.
Details: classList is a DOM property that provides methods like .add(), .remove(), and .toggle() to manage the CSS classes of an element.

*/
let classList = profileDropdownList.classList;

/**
const toggle = () => classList.toggle("active");

Purpose: Defines an arrow function toggle that toggles the class active on the dropdown list.
Details:
If the active class is present, it removes it.
If the active class is absent, it adds it.
Example: This might be used to show or hide the dropdown menu when the button is clicked. 
 */
const toggle = () => classList.toggle("active");

/**
 window.addEventListener("click", function (e) {

Purpose: Adds an event listener to the window object for click events.
Details:
The function runs whenever a click event occurs anywhere in the document.
if (!btn.contains(e.target)) classList.remove("active");

Purpose: Checks if the click event did not occur on the btn element or its children (!btn.contains(e.target)).
Details:
If the condition is true, it removes the active class from the profileDropdownList, hiding the dropdown menu.
});


Purpose: Ends the event listener function.
Details:
This ensures that the dropdown menu closes if a click happens outside the btn element.
 */

window.addEventListener("click", function (e) {
  if (!btn.contains(e.target)) classList.remove("active");
});
