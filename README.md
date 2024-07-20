# Install vendor
`composer update`
# Create file .env
`cp .env.example .env`
# Generate Key
`php artisan key:generate`
# Run server
`php artisan serve`

# Common Method
 -  
    <!-- @message: String -->
    <!-- @type: String ('success' | 'error' | 'info' | 'warning') -->
    `toastCustom (message, type = 'success')`                                

 - 
   <!-- @return: { on, off } -->
   `loading ()`

# Admin Method
 -  
    <!-- @event: Event -->
    `confirmDelete (event: event)`

 -  
    <!-- @route: String -->
    <!-- @formData: FormData -->
    <!-- @callBackSuccess: function (data) { // } -->
    <!-- @callBackError: function (errors) { // } -->
    `postFormData (route, formData, callBackSuccess = null, callBackError = null)`

 - 
   <!-- @fieldsNeedValid: Object - this has key === key of errors -->
   <!-- @errors: Object -->
   `setErrorValidate (fieldsNeedValid, errors = {})`