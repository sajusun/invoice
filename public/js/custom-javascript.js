/*don`t remove any global var*/
// (function () {
//     const user = new User();
//     user.isValid_User();
// })();

$(document).ready(function () {
   const invoice= new InvoiceGenerator();
   invoice.invoiceRows();
   invoice.valueInput();
});







