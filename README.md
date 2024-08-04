# Install vendor
```
composer update
```
# Create file .env
```
cp .env.example .env
```
# Generate Key
```
php artisan key:generate
```
# Run server
```
php artisan serve
```

# Controller Method
 - 
   <!-- @return: path <String> | false -->
   ```
   uploadImage ($file)
   ```

# Common Method
 -  
    <!-- @message: String -->
    <!-- @type: String ('success' | 'error' | 'info' | 'warning') -->
    ```
    toastCustom (message, type = 'success')
    ```                                

 - 
   <!-- @return: { on, off } -->
   ```
   loading ()
   ```

# Admin Method
 -  
   <!-- Xác nhận xóa khi muốn gửi form xóa đi -->
    <!-- @event: Event -->
    ```
    confirmDelete (event: event)
    ```

 -  
   <!-- Dùng để post formData lên server (call API) -->
    <!-- @route: String -->
    <!-- @formData: FormData -->
    <!-- @callBackSuccess: function (data) { // } -->
    <!-- @callBackError: function (errors) { // } -->
    ```
    postFormData (route, formData, callBackSuccess = null, callBackError = null, method = 'POST')
    ```

 - 
   <!-- Hiển thị lỗi validate khi validate qua API -->
   <!-- @fieldsNeedValid: Object - this has key === key of errors -->
   <!-- @errors: Object -->
   ```
   setErrorValidate (fieldsNeedValid, errors = {})
   ```

 - 
   <!-- Submit form khi thay đổi select -->
   <!-- @target: Thẻ select -->
   ```
   onChangeSort(target)
   ```