# Multi Platform Website 

## TODO
- [ ] Add docs to backend
- [ ] Add docs to frontend
- [x] Implement all backend routes 
- [ ] Implement database integration in backend
- [x] Finalise frontend theme
- [ ] Create frontend database abstractions
- [x] Implement website assets from zip 
- [ ] Abstract backend IO operations (reading files, json decoding / encoding)
- [x] Add objects for API return values, use functions in a factory pattern.
      - Have a function for common codes, with a generic one which accepts a number
- [x] Implement objects for query/JSON params, allow for defaults / optionals
- [ ] Change to UUID for keying (done for backend), use auto increment for ordering
- [x] Implement tailwind css
- [ ] Create custom, styled, components that follow the theme
- [x] Use a CSS framework for material design (tailwind)
- [ ] Use useContext & an AuthContext component for authentication state management
- [ ] Change CORS policy in backend
## Ideas
- Use an incremental ID system for blog posts, for easier pagination.
- Use UUID for keying and auto increment for ordering
- CAPTCHA integration
- Ratelimiting

## Useful Resources
-  php -S localhost:8000 api.php (local php server with hot reload)
-  https://www.php.net/manual/en/function.com-create-guid.php
-  https://stackoverflow.com/questions/63340241/material-ui-customizing-box-component-with-withstyles

