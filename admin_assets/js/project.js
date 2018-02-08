/*For converting into JSON Format*/
    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
/*Validation*/    
var name_alpha_pattern=/^[a-zA-Z]+[a-zA-Z ]+$/;
var namepattern = /^[a-zA-Z]+[a-zA-Z_., ]+$/;
var name_all_pattern = /^[a-zA-Z]+[a-zA-Z_.,0-9 - &()  ]+$/;
var name_num_pattern=/^[a-zA-Z0-9 ]+$/;
var name_spl_pattern=/^[a-zA-Z]+[a-zA-Z_.,@&! ]+$/;
var emailpattern = /^[a-zA-Z0-9][a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
var passwordpattern=/^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;
var mobilepattern = /^[6-9]+[0-9]{9}$/;
var pincodepatteren=/^[0-9]{6}$/;
var numberpattern=/^[0-9]+$/;
var landlinepattern=/^[0-9]\d{2,4}\d{6,8}$/;
var special_patterns=/^[0-9 !@#$%^&*()-_+=<>?/]+$/;
var pricepattern=/^\d{0,8}(\.\d{1,4})?$/;

function ucFirst(string) { return string.substring(0, 1).toUpperCase() + string.substring(1).toLowerCase(); }
function email_check(inputdata) 
{ 
    if(inputdata=='')
    { return 0; } 
    if(inputdata!='' && !emailpattern.test(inputdata)) 
    { return 0; } 
    if(special_patterns.test(inputdata[0]))
    { return 0; } 
    
}
function mobile_check(inputdata) { if(inputdata==''){return 0;} if(inputdata!='' && !mobilepattern.test(inputdata)) { return 0;}}
function pincode_check(inputdata) { if(inputdata==''){return 0;} if(inputdata!='' && !pincodepatteren.test(inputdata)) { return 0; }  }
function empty_check(inputdata){ if(inputdata==''){return 0;}  }
function name_check(inputdata){ if(inputdata==''){return 0;}if(inputdata!='' && !namepattern.test(inputdata)) { return 0; }  }
function alphabets_check(inputdata){ if(inputdata==''){ return 0; } if(inputdata!='' && !name_alpha_pattern.test(inputdata)) { return 0; } }
function name_all_check(inputdata){ if(inputdata==''){ return 0; } if(inputdata!='' && !name_all_pattern.test(inputdata)) { return 0; } }
function alphanumeric_check(inputdata){ if(inputdata==''){ return 0; } if(inputdata!='' && !name_num_pattern.test(inputdata)) { return 0; } }
function alpha_splchars_check(inputdata){ if(inputdata==''){ return 0; } if(inputdata!='' && !name_spl_pattern.test(inputdata)) { return 0; } }
function number_check(inputdata){ if(inputdata==''){ return 0; } if(inputdata!='' && !numberpattern.test(inputdata)) { return 0; } }
function landline_check(inputdata){ if(inputdata==''){ return 0; } if(inputdata!='' && !landlinepattern.test(inputdata)) { return 0; } }
function price_check(inputdata){ if(inputdata==''){ return 0; } if(inputdata!='' && !pricepattern.test(inputdata)) { return 0; } }
$('.number_class').on('keyup',function(){
    //(isNaN($(this).val()))?$(this).val(''):'';}
            var input = $(this);
            input.val(input.val().replace(/[^\d.]/g, ''));
            });
$('.mobile_class').on('keyup',function(){
	var mobile=$(this).val();
	(isNaN(mobile) && (mobile[0] > 6))?$(this).val(''):'';
	});
function image_validate(image)
{
    var ext = image.match(/\.(.+)$/)[1];
    ext=ext.toLowerCase();
    validformat='';
    switch(ext) 
    {
        case 'jpg': case 'jpeg': case 'bmp': case 'png': case 'tif': case 'gif':
        validformat=1; break;
        default: validformat=0; 
    }
    return validformat;
}
function csv_validate(csvfile)
{
    var ext = csvfile.match(/\.(.+)$/)[1];
    ext=ext.toLowerCase();
    validformat='';
    switch(ext) 
    {
        case 'csv':
        validformat=1; break;
        default: validformat=0; 
    }
    return validformat;
}
//Check Internet connected or not
function checkInternet(){
    var c_i=navigator.onLine ?1:0;
    return c_i;
}

function  validatepdfdocimage(inputfile)
{
    var ext = inputfile.match(/\.(.+)$/)[1];
    ext=ext.toLowerCase();
    validformat='';
    switch(ext) 
    {
        case 'jpg': case 'jpeg': case 'bmp': case 'png': case 'tif': case 'gif':
        case 'doc':case 'pdf': case 'docx': case 'xlsx':               
        validformat=1; break;
        default: validformat=0; 
    }
    return ext;
}

function taxcalculation(price,tax)
{
    price = parseFloat(price);
    tax = parseFloat(tax);
    var taxamount = ((price * tax) / 100);
    var finalprice=(parseFloat(price)+parseFloat(taxamount));
    var discountprice=(parseFloat(price)-parseFloat(taxamount));
    var obj = {
            inputtax:  tax,
            inputprice: price,
            taxamount: taxamount,
            finalprice:finalprice,
            discountprice:discountprice
          };
    return obj;

}