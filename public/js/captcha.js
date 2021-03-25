var code;
function createCaptcha() {
  //clear the contents of captcha div first 
  document.getElementById('captcha').innerHTML = "";
  var charsArray =
  "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
  var lengthOtp = 6;
  var captcha = [];
  for (var i = 0; i < lengthOtp; i++) {
    //below code will not allow Repetition of Characters
    var index = Math.floor(Math.random() * charsArray.length + 1); //get the next character from the array
    if (captcha.indexOf(charsArray[index]) == -1)
      captcha.push(charsArray[index]);
    else i--;
  }
  var canv = document.createElement("canvas");
  canv.id = "captcha";
  canv.width = 100;
  canv.height = 50;
  var ctx = canv.getContext("2d");
  ctx.font = "25px Georgia";
  ctx.strokeText(captcha.join(""), 0, 30);
  //storing captcha so that can validate you can save it somewhere else according to your specific requirements
  code = captcha.join("");
  document.getElementById("captcha").appendChild(canv); // adds the canvas to the body element
}

function validateCaptcha() {
  event.preventDefault();
  debugger
  if (document.getElementById("cpatchaTextBox").value == code) {
    console.log("Valid Captcha");
    return true;
  }else{
    Notiflix.Report.Failure('Not match with the captcha!','<p style="text-align:center;">Please try again.</p>', {cssAnimationStyle:'zoom', cssAnimationDuration:500 });
    createCaptcha();
    return false;
  }
}


// Math Captcha

function randomnum()
{
        var number1 = 5;
        var number2 = 50;
        var randomnum = (parseInt(number2) - parseInt(number1)) + 1;
        var rand1 = Math.floor(Math.random()*randomnum)+parseInt(number1);
        var rand2 = Math.floor(Math.random()*randomnum)+parseInt(number1);
        $(".rand1").html(rand1);
        $(".rand2").html(rand2);
}

function validateMathCaptcha(){
    var total=parseInt($('.rand1').html())+parseInt($('.rand2').html());
    var total1=$('#total').val();
    if(total!=total1)
    {
        randomnum();
        Notiflix.Report.Failure('Summation Error!','<p style="text-align:center;">Please try again.</p>', {cssAnimationStyle:'zoom', cssAnimationDuration:500 });
        return false;
    }
    else
    {
        console.log('valid math captcha');
        return true;
    }
}