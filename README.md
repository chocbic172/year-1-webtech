# UCLan Shop Webapp

**Student Name:** Ethan Howard\
**Student ID:** 21255926\
**Live Wesbite URL:** https://vesta.uclan.ac.uk/~ehoward4/webtech1 \
**Github Repo URL:** https://github.com/chocbic172/year-1-webtech

## Example Credentials
To test the website, the following example credentials can be used:\
**Username:** `testuser`\
**Password:** `S3curePa$$w0rd`

## Design Descisions
- During registration, we do not ask for a users address. This is to simplify the process and
  encourage more users to sign up. A users address can instead be saved in the checkout stage.
- Client side (in browser) form validation has been turned off to demonstrate website
  capabilities. In a real deployment it would be beneficial to enable this.
- Prepared SQL statements are used to generate all user related INSERTs. This prevents SQL
  injection attacks. We also filter out HTML/XSS attacks by escaping special HTML characters.
- All database functions were abtracted to `utils/database.php`. This significatly simplified
  the creation new pages as the database functionality did not have to be ported. I considered
  using the [ORM](https://en.wikipedia.org/wiki/Object%E2%80%93relational_mapping) paradigm, but
  decided against it due to time constraints. This seemed like a good compromise between the 
  developer experience of ORM, and the simplicity of direct implementation.
- Some common frontend UI components (navbar, footer) were saved to the `components` folder. They
  are then imported in each page, meaning an update to the component affected the design sitewide.

## Wider Reading
The main resources used during development were:
- [The official PHP documentation](https://www.php.net/docs.php) - Used extensively in researching and using the inbuilt language features of PHP.
- [W3 School](https://www.w3schools.com/php/default.asp) - Used for researching features of SQL, and for some more advanced use cases of PHP classes.
- [MDN Web Docs](https://developer.mozilla.org/en-US/) - Used for researching HTML accessibility features, and for the javascript implementation of the "Add To Cart" button.

## Acessibility and Usability
- Images all use the `alt` attribute to provide context for screenreaders.
- Form fields are sensibly named and labelled for visually impared website users.
- All text elements were sufficiently visible against their backgrounds.
