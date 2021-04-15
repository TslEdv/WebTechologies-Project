# ICD0007_ppTable
## Group description: Room planning and check tool for restrictions and room suitability (e.g, room with audio support, COVID-restrictions, etc.)
### Group members:
Edvin Ess: edvess@taltech.ee responsible for: user management logic, cookies and sessions, login, register, contact pages, overall code overview

Mihkel Kiil: mikiil@taltech.ee responsible for: room availability checking, security, booking creation, booking, bug fixes. 

Kristiina Šamanina: krsama@taltech.ee responsible for: display of available rooms, input validation, minor contributions to all pages, design of home page, coordination, lead designer.

CSS was a joint responsibility among all team members.

Future roles will be allocated as the project progresses.

### Technical description
There are 4 rooms available in total. To view all rooms, you can set a capacity of 2. Due to the current situation, rooms are limited to 50% capacity.

Milestone 1 is in master branch in milestone1 tag.

Milestone 2 is in master branch in milestone2r tag with corrections.

The project is available in the following link: https://enos.itcollege.ee/~krsama/project_pptable/

### Known issues

* Rooms do not display capacity
* Messy layout setup on user management pages
* My bookings says "here are your bookings" even when the user has no bookings
* Date text does not fit into form fields
* No limit per user, no CAPTCHA
* ISO8601 format on confirmation page is too technical for the average user
* Passwords are sanitised and hashed with SHA1
* Feedback uses CSV and does not log IP
* Booking form page requests users to log in, even when they are logged in

### Features to add:
 
 * Logout confirmation
 * Show password button
 * Feedback submission confirmation


