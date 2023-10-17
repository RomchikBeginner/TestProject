    <footer class="footer">
        <div class="container">
            
        </div>
    </footer>
    <script type="text/javascript">
        function ValidPhone() {
            var re = /^[\d\+][\d\(\)\ -]{4,14}\d$/;
            var myPhone = document.getElementById('phone').value;
            var valid = re.test(myPhone);
            if (valid) output = 'Номер телефона введен правильно!';
            else output = 'Номер телефона введен неправильно!';
            document.getElementById('message').innerHTML = document.getElementById('message').innerHTML+'<br />'+output;
            return valid;
        }  
    </script>
</body>

</html>