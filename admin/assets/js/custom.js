$(document).ready(function () {
  alertify.set("notifier", "position", "top-right"); // Function to show on the top form Alertify

  $(document).on("click", ".increment", function () {
    // jqon

    var $quantityInput = $(this).closest(".qtyBox").find(".qty");
    var ProdcutId = $(this).closest(".qtyBox").find(".proId").val();
    var currenValue = parseInt($quantityInput.val());

    if (!isNaN(currenValue)) {
      var qtyVal = currenValue + 1;
      $quantityInput.val(qtyVal);
      $quantityIncDec(ProdcutId, qtyVal);
    }
  });

  $(document).on("click", ".decrement", function () {
    var $quantityInput = $(this).closest(".qtyBox").find(".qty");
    var ProdcutId = $(this).closest(".qtyBox").find(".proId").val();
    var currenValue = parseInt($quantityInput.val());

    if (!isNaN(currenValue) && currenValue > 1) {
      var qtyVal = currenValue - 1;
      $quantityInput.val(qtyVal);
      $quantityIncDec(ProdcutId, qtyVal);
    }
  });

  //   To Update Store Session Variable
  function $quantityIncDec(proId, qty) {
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: {
        productIncDec: true,
        product_id: proId,
        quantity: qty,
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.status == 200) {
          // window.location.reload();
          console.log(res);
          $("#productArea").load(" #productContent");
          // JQuery to show the message
          alertify.success(res.message);
        } else {
          $("#productArea").load(" #productContent");
          alertify.error(res.message);
        }
      },
    });
  }

  // Process to place the order
  $(document).on("click", ".processedToPlace", function () {
    var cphone = $("#cphone").val();
    var payment_method = $("#payment_method").val();

    if (payment_method == "") {
      swal("Select Payment Method", "Select your payment Method", "warning"); //Using Sweet Alert
      return false;
    }

    if (cphone == "" && !$.isNumeric(cphone)) {
      swal("Enter Phone Number", "Enter Valid Phone Number", "warning");
    }

    var data = {
      processedToPlaceBtn: true,
      cphone: cphone,
      payment_method: payment_method,
    };

    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: data,
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          window.location.href = "order-summary.php";
        } else if (res.status == 404) {
          swal(res.message, res.message, res.status_type, {
            buttons: {
              catch: {
                text: "Add Customer",
                value: "catch",
              },
              cancel: "Cancel",
            },
          }).then((value) => {
            switch (value) {
              case "catch":
                // console.log('Pop the customer add modal');

                $("#c_phone").val(cphone); //  to Add the phone number  found to Form Pop up
                $("#addCustomerModal").modal("show");
                break;
              default:
            }
          });
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });

  //  Add Customer on the Pop orderForm

  $(document).on("click", ".saveCustomer", function () {
    var c_name = $("#c_name").val();
    var c_phone = $("#c_phone").val();
    var c_email = $("#c_email").val();

    if (c_name != "" && c_phone != "") {
      if ($.isNumeric(c_phone)) {
        var data = {
          saveCustomerBtn: true,
          name: c_name,
          phone: c_phone,
          email: c_email,
        };

        $.ajax({
          type: "POST",
          url: "orders-code.php",
          data: data,
          success: function (response) {
            var res = JSON.parse(response);

            if (res.status == 200) {
              swal(res.message, res.message, res.status_type);

              $("#addCustomerModal").modal("hide");
              // The Data Added to Hide the Modal Pop Up
            } else if (res.status == 422) {
              swal(res.message, res.message, res.status_type);
            } else {
              swal(res.message, res.message, res.status_type);
            }
          },
        });
      } else {
        swal("Enter Valid Phone Number", "", "warning");
      }
    } else {
      swal("Please Fill required fields", "", "warning");
    }
  });

  // Save Orders

  $(document).on("click", "#saveOrder", function () {
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: {
        saveOrder: true,
      },
      success: function (response) {
        var res = JSON.parse(response);

        if (res.status == 200) {
          swal(res.message, res.message, res.status_type);
          $("#orderPlaceSuccessMessage").text(res.message);
          $("#orderSuccessModal").modal("show");
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });
});


// To Print the order on order-view-prints.php

function printMyBillingArea(){

  var divContenets = document.querySelector("#myBillingArea").innerHTML; //innerHTML get all elements form File
  var a = window.open('', '');
  a.document.write('<html><title>Fashion POS System</title>');
  a.document.write('<body style="font-family: fangsong;">');
  a.document.write(divContenets);
  a.document.write('</body></html>');
  a.document.close();
  a.print();
}

// Download PDF Function

window.jsPDF = window.jspdf.jsPDF;
var docPDF = new jsPDF;

function downloadPDF(invoice_no){
  
  var elementHTML =  document.querySelector("#myBillingArea");
  docPDF.html(elementHTML, {
      callback: function(){
        docPDF.save(invoice_no+'.pdf');

      },
      x:15,
      y:15,
      width: 170,
      windowWidth:650
  });


}