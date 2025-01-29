<script>
//Mobile Number
$(document).ready(function(){
  $('.onlynine').on('input', function(){
    var inputValue = $(this).val();
    if(inputValue.charAt(0) !== '9'){
      $(this).val(inputValue.substring(1));
    }
  })
});

$(document).ready(function() {
  var today = new Date();
  var minDate = new Date(today.getFullYear() - 65, today.getMonth(), today.getDate());
  var maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

  var minDateString = minDate.toISOString().split('T')[0];
  var maxDateString = maxDate.toISOString().split('T')[0];

  $('#dob').attr('min', minDateString);
  $('#dob').attr('max', maxDateString);

  $('#dob').on('input', function() {
      var inputDate = new Date($(this).val());
      if (inputDate < minDate || inputDate > maxDate) {
          $(this).val('');
      }
  });
});

//Number only
$('.number').on('input', function (event) { 
  this.value = this.value.replace(/[^0-9]/g, '');
});

//Text only
$('.letter').on('input', function (event) { 
  this.value = this.value.replace(/[^a-zA-Z ]/g, '');
});

//for dashes of mobile
$('.mobile').keyup(function(){
  $(this).val($(this).val().match(/\d+/g).join("").replace(/(\d{3})\-?(\d{4})\-?(\d{3})/,'$1-$2-$3'))
});

//landline
$('.landline').keyup(function() {
var foo = $(this).val().split("-").join(""); // remove hyphens
if (foo.length > 0) {
  foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
}
$(this).val(foo);
});

//SSS
$('.SSS').keyup(function() {
var foo = $(this).val().split("-").join(""); // remove hyphens
if (foo.length > 0) {
  foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
}
$(this).val(foo);
});

//TIN
$('.TIN').keyup(function() {
var foo = $(this).val().split("-").join(""); // remove hyphens
if (foo.length > 0) {
  foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
}
$(this).val(foo);
});

  $('#otherId').change(function() {$('#otherIds').val('')});

  $('#otherId').change(function(){
    var selected = $(this).children("option:selected").val();
    if(selected == 1){
        $('#otherIds').attr('placeholder', 'XXXX-XXXXXXXX-X');
        $('#otherIds').attr('maxlength', '12');
        $('#otherIds').attr('required', 'required');
        $('#otherIds').keyup(function(){
        $(this).val($(this).val().match(/\d+/g).join("").replace(/(\d{3})\-?(\d{8})\-?(\d{1})/,'$1-$2-$3'))
        });
       
    }
    else if(selected == 2){
        $('#otherIds').attr('placeholder', 'A00-00-000000');
        $('#otherIds').attr('maxlength', '11');
        $('#otherIds').setAttribute('required', 'required');
        $('#otherIds').val("");
        $('#otherIds').keyup(function(){
        $(this).val($(this).val().match(/\d+/g).join("").replace(/(\d{3})\-?(\d{2})\-?(\d{6})/,'$1-$2-$3'))
        });
      
    }
    else if(selected == 3){
      $('#otherIds').attr('placeholder', 'PXXXXXXX');
      $('#otherIds').attr('maxlength', '7');
      $('#otherIds').setAttribute('required', 'required');
    }
    else if(selected == 4){
      $('#otherIds').attr('placeholder', 'XXXX-XXXX-XXXX');
      $('#otherIds').attr('maxlength', '12');
      $('#otherIds').setAttribute('required', 'required');
      $('#otherIds').keyup(function(){
      $(this).val($(this).val().match(/\d+/g).join("").replace(/(\d{4})\-?(\d{4})\-?(\d{4})\-?(\d{4})/,'$1-$2-$3-$4'))
      });
    }
    else if(selected == 5){
      $('#otherIds').attr('placeholder', 'XX-XXXXXXXX-X');
      $('#otherIds').attr('maxlength', '11');
      $('#otherIds').setAttribute('required', 'required');
      $('#otherIds').keyup(function(){
      $(this).val($(this).val().match(/\d+/g).join("").replace(/(\d{2})\-?(\d{8})\-?(\d{1})/,'$1-$2-$3'))
      });
    }
    else if(selected == 6){
      $('#otherIds').attr('placeholder', 'PRN XXXXXXXXXXXX');
      $('#otherIds').attr('maxlength', '12');
      $('#otherIds').setAttribute('required', 'required');
    }
    else if(selected == 7){
      $('#otherIds').attr('placeholder', 'XXXX-XXX-XXXX-X');
      $('#otherIds').attr('maxlength', '12');
      $('#otherIds').setAttribute('required', 'required');
      $('#otherIds').keyup(function(){
      $(this).val($(this).val().match(/\d+/g).join("").replace(/(\d{4})\-?(\d{3})\-?(\d{4})\-?(\d{1})/,'$1-$2-$3-$4'))
      });
    }
    else if(selected == 8){
      $('#otherIds').attr('placeholder', 'XXXXXXXX');
      $('#otherIds').attr('maxlength', '8');
      $('#otherIds').setAttribute('required', 'required');
    }
    else if(selected == 9){
      $('#otherIds').attr('placeholder', 'XXXXXXXXXX-XXXXXXXXXX');
      $('#otherIds').attr('maxlength', '21');
      $('#otherIds').setAttribute('required', 'required');
      $('#otherIds').keyup(function() {
      var foo = $(this).val().split("-").join(""); // remove hyphens
      if (foo.length > 0) {
        foo = foo.match(new RegExp('.{1,10}', 'g')).join("-");
      }
      $(this).val(foo);
      });
    }
    else if(selected == 10){
      $('#otherIds').attr('placeholder', 'Enter ID Number');
      $('#otherIds').attr('maxlength', '25');
      $('#otherIds').setAttribute('required', 'required');
      
    }
    else{
      $('#otherIds').attr('placeholder', '');
      $('#otherIds').attr('maxlength', '');
      $('#otherIds').removeAttribute('required');
    }
  });
</script>