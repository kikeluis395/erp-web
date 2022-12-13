export default [
    {
        codigo: "0100",
        descripcion: "El sistema no puede responder su solicitud. Intente nuevamente o comuníquese con su Administrador",
        tipo:'Excepción'
    },
    {
        codigo: "0101",
        descripcion: "El encabezado de seguridad es incorrecto",
        tipo:'Excepción'
    },
    {
        codigo: "0102",
        descripcion: "Usuario o contraseña incorrectos",
        tipo:'Excepción'
    },
    {
        codigo: "0103",
        descripcion: "El Usuario ingresado no existe",
        tipo:'Excepción'
    },
    {
        codigo: "0104",
        descripcion: "La Clave ingresada es incorrecta",
        tipo:'Excepción'
    },
    {
        codigo: "0105",
        descripcion: "El Usuario no está activo",
        tipo:'Excepción'
    },
    {
        codigo: "0106",
        descripcion: "El Usuario no es válido",
        tipo:'Excepción'
    },
    {
        codigo: "0109",
        descripcion: "El sistema no puede responder su solicitud. (El servicio de autenticación no está disponible)",
        tipo:'Excepción'
    },
    {
        codigo: "0110",
        descripcion: "No se pudo obtener la informacion del tipo de usuario",
        tipo:'Excepción'
    },
    {
        codigo: "0111",
        descripcion: "No tiene el perfil para enviar comprobantes electronicos",
        tipo:'Excepción'
    },
    {
        codigo: "0112",
        descripcion: "El usuario debe ser secundario",
        tipo:'Excepción'
    },
    {
        codigo: "0113",
        descripcion: "El usuario no esta afiliado a Factura Electronica",
        tipo:'Excepción'
    },
    {
        codigo: "0125",
        descripcion: "No se pudo obtener la constancia",
        tipo:'Excepción'
    },
    {
        codigo: "0126",
        descripcion: "El ticket no le pertenece al usuario",
        tipo:'Excepción'
    },
    {
        codigo: "0127",
        descripcion: "El ticket no existe",
        tipo:'Excepción'
    },
    {
        codigo: "0130",
        descripcion: "El sistema no puede responder su solicitud. (No se pudo obtener el ticket de proceso)",
        tipo:'Excepción'
    },
    {
        codigo: "0131",
        descripcion: "El sistema no puede responder su solicitud. (No se pudo grabar el archivo en el directorio)",
        tipo:'Excepción'
    },
    {
        codigo: "0132",
        descripcion: "El sistema no puede responder su solicitud. (No se pudo grabar escribir en el archivo zip)",
        tipo:'Excepción'
    },
    {
        codigo: "0133",
        descripcion: "El sistema no puede responder su solicitud. (No se pudo grabar la entrada del log)",
        tipo:'Excepción'
    },
    {
        codigo: "0134",
        descripcion: "El sistema no puede responder su solicitud. (No se pudo grabar en el storage)",
        tipo:'Excepción'
    },
    {
        codigo: "0135",
        descripcion: "El sistema no puede responder su solicitud. (No se pudo encolar el pedido)",
        tipo:'Excepción'
    },
    {
        codigo: "0136",
        descripcion: "El sistema no puede responder su solicitud. (No se pudo recibir una respuesta del batch)",
        tipo:'Excepción'
    },
    {
        codigo: "0137",
        descripcion: "El sistema no puede responder su solicitud. (Se obtuvo una respuesta nula)",
        tipo:'Excepción'
    },
    {
        codigo: "0138",
        descripcion: "El sistema no puede responder su solicitud. (Error en Base de Datos)",
        tipo:'Excepción'
    },
    {
        codigo: "0151",
        descripcion: "El nombre del archivo ZIP es incorrecto",
        tipo:'Excepción'
    },
    {
        codigo: "0152",
        descripcion: "No se puede enviar por este método un archivo de resumen",
        tipo:'Excepción'
    },
    {
        codigo: "0153",
        descripcion: "No se puede enviar por este método un archivo por lotes",
        tipo:'Excepción'
    },
    {
        codigo: "0154",
        descripcion: "El RUC del archivo no corresponde al RUC del usuario o el proveedor no esta autorizado a enviar comprobantes del contribuyente",
        tipo:'Excepción'
    },
    {
        codigo: "0155",
        descripcion: "El archivo ZIP esta vacio",
        tipo:'Excepción'
    },
    {
        codigo: "0156",
        descripcion: "El archivo ZIP esta corrupto",
        tipo:'Excepción'
    },
    {
        codigo: "0157",
        descripcion: "El archivo ZIP no contiene comprobantes",
        tipo:'Excepción'
    },
    {
        codigo: "0158",
        descripcion: "El archivo ZIP contiene demasiados comprobantes para este tipo de envío",
        tipo:'Excepción'
    },
    {
        codigo: "0159",
        descripcion: "El nombre del archivo XML es incorrecto",
        tipo:'Excepción'
    },
    {
        codigo: "0160",
        descripcion: "El archivo XML esta vacio",
        tipo:'Excepción'
    },
    {
        codigo: "0161",
        descripcion: "El nombre del archivo XML no coincide con el nombre del archivo ZIP",
        tipo:'Excepción'
    },
    {
        codigo: "0200",
        descripcion: "No se pudo procesar su solicitud. (Ocurrio un error en el batch)",
        tipo:'Excepción'
    },
    {
        codigo: "0201",
        descripcion: "No se pudo procesar su solicitud. (Llego un requerimiento nulo al batch)",
        tipo:'Excepción'
    },
    {
        codigo: "0202",
        descripcion: "No se pudo procesar su solicitud. (No llego información del archivo ZIP)",
        tipo:'Excepción'
    },
    {
        codigo: "0203",
        descripcion: "No se pudo procesar su solicitud. (No se encontro archivos en la informacion del archivo ZIP)",
        tipo:'Excepción'
    },
    {
        codigo: "0204",
        descripcion: "No se pudo procesar su solicitud. (Este tipo de requerimiento solo acepta 1 archivo)",
        tipo:'Excepción'
    },
    {
        codigo: "0250",
        descripcion: "No se pudo procesar su solicitud. (Ocurrio un error desconocido al hacer unzip)",
        tipo:'Excepción'
    },
    {
        codigo: "0251",
        descripcion: "No se pudo procesar su solicitud. (No se pudo crear un directorio para el unzip)",
        tipo:'Excepción'
    },
    {
        codigo: "0252",
        descripcion: "No se pudo procesar su solicitud. (No se encontro archivos dentro del zip)",
        tipo:'Excepción'
    },
    {
        codigo: "0253",
        descripcion: "No se pudo procesar su solicitud. (No se pudo comprimir la constancia)",
        tipo:'Excepción'
    },
    {
        codigo: "0300",
        descripcion: "No se encontró la raíz documento xml",
        tipo:'Excepción'
    },
    {
        codigo: "0301",
        descripcion: "Elemento raiz del xml no esta definido",
        tipo:'Excepción'
    },
    {
        codigo: "0302",
        descripcion: "Codigo del tipo de comprobante no registrado",
        tipo:'Excepción'
    },
    {
        codigo: "0303",
        descripcion: "No existe el directorio de schemas",
        tipo:'Excepción'
    },
    {
        codigo: "0304",
        descripcion: "No existe el archivo de schema",
        tipo:'Excepción'
    },
    {
        codigo: "0305",
        descripcion: "El sistema no puede procesar el archivo xml",
        tipo:'Excepción'
    },
    {
        codigo: "0306",
        descripcion: "No se puede leer (parsear) el archivo XML",
        tipo:'Excepción'
    },
    {
        codigo: "0307",
        descripcion: "No se pudo recuperar la constancia",
        tipo:'Excepción'
    },
    {
        codigo: "0400",
        descripcion: "No tiene permiso para enviar casos de pruebas",
        tipo:'Excepción'
    },
    {
        codigo: "0401",
        descripcion: "El caso de prueba no existe",
        tipo:'Excepción'
    },
    {
        codigo: "0402",
        descripcion: "La numeracion o nombre del documento ya ha sido enviado anteriormente",
        tipo:'Excepción'
    },
    {
        codigo: "0403",
        descripcion: "El documento afectado por la nota no existe",
        tipo:'Excepción'
    },
    {
        codigo: "0404",
        descripcion: "El documento afectado por la nota se encuentra rechazado",
        tipo:'Excepción'
    },
    {
        codigo: "1001",
        descripcion: "ID - El dato SERIE-CORRELATIVO no cumple con el formato de acuerdo al tipo de comprobante",
        tipo:'Excepción'
    },
    {
        codigo: "1002",
        descripcion: "El XML no contiene informacion en el tag ID",
        tipo:'Excepción'
    },
    {
        codigo: "1003",
        descripcion: "InvoiceTypeCode - El valor del tipo de documento es invalido o no coincide con el nombre del archivo",
        tipo:'Excepción'
    },
    {
        codigo: "1004",
        descripcion: "El XML no contiene el tag o no existe informacion de InvoiceTypeCode",
        tipo:'Excepción'
    },
    {
        codigo: "1005",
        descripcion: "CustomerAssignedAccountID -  El dato ingresado no cumple con el estandar",
        tipo:'Excepción'
    },
    {
        codigo: "1006",
        descripcion: "El XML no contiene el tag o no existe informacion de CustomerAssignedAccountID del emisor del documento",
        tipo:'Excepción'
    },
    {
        codigo: "1007",
        descripcion: "El dato ingresado no cumple con el estandar",
        tipo:'Excepción'
    },
    {
        codigo: "1008",
        descripcion: "El XML no contiene el tag o no existe informacion en tipo de documento del emisor.",
        tipo:'Excepción'
    },
    {
        codigo: "1009",
        descripcion: "IssueDate - El dato ingresado  no cumple con el patron YYYY-MM-DD",
        tipo:'Excepción'
    },
    {
        codigo: "1010",
        descripcion: "El XML no contiene el tag IssueDate",
        tipo:'Excepción'
    },
    {
        codigo: "1011",
        descripcion: "IssueDate- El dato ingresado no es valido",
        tipo:'Excepción'
    },
    {
        codigo: "1012",
        descripcion: "ID - El dato ingresado no cumple con el patron SERIE-CORRELATIVO",
        tipo:'Excepción'
    },
    {
        codigo: "1013",
        descripcion: "El XML no contiene informacion en el tag ID",
        tipo:'Excepción'
    },
    {
        codigo: "1014",
        descripcion: "CustomerAssignedAccountID - El dato ingresado no cumple con el estandar",
        tipo:'Excepción'
    },
    {
        codigo: "1015",
        descripcion: "El XML no contiene el tag o no existe informacion de CustomerAssignedAccountID del emisor del documento",
        tipo:'Excepción'
    },
    {
        codigo: "1016",
        descripcion: "AdditionalAccountID - El dato ingresado no cumple con el estandar",
        tipo:'Excepción'
    },
    {
        codigo: "1017",
        descripcion: "El XML no contiene el tag AdditionalAccountID del emisor del documento",
        tipo:'Excepción'
    },
    {
        codigo: "1018",
        descripcion: "IssueDate - El dato ingresado no cumple con el patron YYYY-MM-DD",
        tipo:'Excepción'
    },
    {
        codigo: "1019",
        descripcion: "El XML no contiene el tag IssueDate",
        tipo:'Excepción'
    },
    {
        codigo: "1020",
        descripcion: "IssueDate- El dato ingresado no es valido",
        tipo:'Excepción'
    },
    {
        codigo: "1021",
        descripcion: "Error en la validacion de la nota de credito",
        tipo:'Excepción'
    },
    {
        codigo: "1022",
        descripcion: "La serie o numero del documento modificado por la Nota Electrónica no cumple con el formato establecido",
        tipo:'Excepción'
    },
    {
        codigo: "1023",
        descripcion: "No se ha especificado el tipo de documento modificado por la Nota electronica",
        tipo:'Excepción'
    },
    {
        codigo: "1024",
        descripcion: "CustomerAssignedAccountID - El dato ingresado no cumple con el estandar",
        tipo:'Excepción'
    },
    {
        codigo: "1025",
        descripcion: "El XML no contiene el tag o no existe informacion de CustomerAssignedAccountID del emisor del documento",
        tipo:'Excepción'
    },
    {
        codigo: "1026",
        descripcion: "AdditionalAccountID - El dato ingresado no cumple con el estandar",
        tipo:'Excepción'
    },
    {
        codigo: "1027",
        descripcion: "El XML no contiene el tag AdditionalAccountID del emisor del documento",
        tipo:'Excepción'
    },
    {
        codigo: "1028",
        descripcion: "IssueDate - El dato ingresado no cumple con el patron YYYY-MM-DD",
        tipo:'Excepción'
    },
    {
        codigo: "1029",
        descripcion: "El XML no contiene el tag IssueDate",
        tipo:'Excepción'
    },
    {
        codigo: "1030",
        descripcion: "IssueDate- El dato ingresado no es valido",
        tipo:'Excepción'
    },
    {
        codigo: "1031",
        descripcion: "Error en la validacion de la nota de debito",
        tipo:'Excepción'
    },
    {
        codigo: "1032",
        descripcion: "El comprobante ya esta informado y se encuentra con estado anulado o rechazado",
        tipo:'Excepción'
    },
    {
        codigo: "1033",
        descripcion: "El comprobante fue registrado previamente con otros datos",
        tipo:'Excepción'
    },
    {
        codigo: "1034",
        descripcion: "Número de RUC del nombre del archivo no coincide con el consignado en el contenido del archivo XML",
        tipo:'Excepción'
    },
    {
        codigo: "1035",
        descripcion: "Numero de Serie del nombre del archivo no coincide con el consignado en el contenido del archivo XML",
        tipo:'Excepción'
    },
    {
        codigo: "1036",
        descripcion: "Número de documento en el nombre del archivo no coincide con el consignado en el contenido del XML",
        tipo:'Excepción'
    },
    {
        codigo: "1037",
        descripcion: "El XML no contiene el tag o no existe informacion de RegistrationName del emisor del documento",
        tipo:'Excepción'
    },
    {
        codigo: "1038",
        descripcion: "RegistrationName - El nombre o razon social del emisor no cumple con el estandar",
        tipo:'Excepción'
    },
    {
        codigo: "1039",
        descripcion: "Solo se pueden recibir notas electronicas que modifican facturas",
        tipo:'Excepción'
    },
    {
        codigo: "1040",
        descripcion: "El tipo de documento modificado por la nota electronica no es valido",
        tipo:'Excepción'
    },
    {
        codigo: "1041",
        descripcion: "cac:PrepaidPayment/cbc:ID - El tag no contiene el atributo @SchemaID. que indica el tipo de documento que realiza el anticipo",
        tipo:'Excepción'
    },
    {
        codigo: "1042",
        descripcion: "cac:PrepaidPayment/cbc:InstructionID – El tag no contiene el atributo @SchemaID. Que indica el tipo de documento del emisor del documento del anticipo.",
        tipo:'Excepción'
    },
    {
        codigo: "1043",
        descripcion: "cac:OriginatorDocumentReference/cbc:ID - El tag no contiene el atributo @SchemaID. Que indica el tipo de documento del originador del documento electrónico.",
        tipo:'Excepción'
    },
    {
        codigo: "1044",
        descripcion: "cac:PrepaidPayment/cbc:InstructionID – El dato ingresado no cumple con el estándar.",
        tipo:'Excepción'
    },
    {
        codigo: "1045",
        descripcion: "cac:OriginatorDocumentReference/cbc:ID – El dato ingresado no cumple con el estándar.",
        tipo:'Excepción'
    },
    {
        codigo: "1046",
        descripcion: "cbc:Amount - El dato ingresado no cumple con el estándar.",
        tipo:'Excepción'
    },
    {
        codigo: "1047",
        descripcion: "cbc:Quantity - El dato ingresado no cumple con el estándar.",
        tipo:'Excepción'
    },
    {
        codigo: "1048",
        descripcion: "El XML no contiene el tag o no existe información de PrepaidAmount para un documento con anticipo.",
        tipo:'Excepción'
    },
    {
        codigo: "1049",
        descripcion: "ID - Serie y Número del archivo no coincide con el consignado en el contenido del XML.",
        tipo:'Excepción'
    },
    {
        codigo: "1050",
        descripcion: "El XML no contiene informacion en el tag DespatchAdviceTypeCode.",
        tipo:'Excepción'
    },
    {
        codigo: "1051",
        descripcion: "DespatchAdviceTypeCode - El valor del tipo de guía es inválido.",
        tipo:'Excepción'
    },
    {
        codigo: "1052",
        descripcion: "DespatchAdviceTypeCode - No coincide con el consignado en el contenido del XML.",
        tipo:'Excepción'
    },
    {
        codigo: "1053",
        descripcion: "cac:OrderReference - El XML no contiene informacion en serie y numero dado de baja (cbc:ID).",
        tipo:'Excepción'
    },
    {
        codigo: "1054",
        descripcion: "cac:OrderReference - El valor en numero de documento no cumple con un formato valido (SERIE-NUMERO).",
        tipo:'Excepción'
    },
    {
        codigo: "1055",
        descripcion: "cac:OrderReference - Numero de serie del documento no cumple con un formato valido (EG01 ó TXXX).",
        tipo:'Excepción'
    },
    {
        codigo: "1056",
        descripcion: "cac:OrderReference - El XML no contiene informacion en el código de tipo de documento (cbc:OrderTypeCode).",
        tipo:'Excepción'
    },
    {
        codigo: "1057",
        descripcion: "cac:AdditionalDocumentReference - El XML no contiene el tag o no existe información en el numero de documento adicional (cbc:ID).",
        tipo:'Excepción'
    },
    {
        codigo: "1058",
        descripcion: "cac:AdditionalDocumentReference - El XML no contiene el tag o no existe información en el tipo de documento adicional (cbc:DocumentTypeCode).",
        tipo:'Excepción'
    },
    {
        codigo: "1059",
        descripcion: "El XML no contiene firma digital.",
        tipo:'Excepción'
    },
    {
        codigo: "1060",
        descripcion: "cac:Shipment - El XML no contiene el tag o no existe informacion del numero de RUC del Remitente (cac:).",
        tipo:'Excepción'
    },
    {
        codigo: "1061",
        descripcion: "El numero de RUC del Remitente no existe.",
        tipo:'Excepción'
    },
    {
        codigo: "1062",
        descripcion: "El XML no contiene el atributo o no existe informacion del motivo de traslado.",
        tipo:'Excepción'
    },
    {
        codigo: "1063",
        descripcion: "El valor ingresado como motivo de traslado no es valido.",
        tipo:'Excepción'
    },
    {
        codigo: "1064",
        descripcion: "El XML no contiene el atributo o no existe informacion en el tag cac:DespatchLine de bienes a transportar.",
        tipo:'Excepción'
    },
    {
        codigo: "1065",
        descripcion: "El XML no contiene el atributo o no existe informacion en modalidad de transporte.",
        tipo:'Excepción'
    },
    {
        codigo: "1066",
        descripcion: "El XML no contiene el atributo o no existe informacion de datos del transportista.",
        tipo:'Excepción'
    },
    {
        codigo: "1067",
        descripcion: "El XML no contiene el atributo o no existe información de vehiculos.",
        tipo:'Excepción'
    },
    {
        codigo: "1068",
        descripcion: "El XML no contiene el atributo o no existe información de conductores.",
        tipo:'Excepción'
    },
    {
        codigo: "1069",
        descripcion: "El XML no contiene el atributo o no existe información de la fecha de inicio de traslado o fecha de entrega del bien al transportista.",
        tipo:'Excepción'
    },
    {
        codigo: "1070",
        descripcion: "El valor ingresado  como fecha de inicio o fecha de entrega al transportista no cumple con el estandar (YYYY-MM-DD).",
        tipo:'Excepción'
    },
    {
        codigo: "1071",
        descripcion: "El valor ingresado  como fecha de inicio o fecha de entrega al transportista no es valido.",
        tipo:'Excepción'
    },
    {
        codigo: "1072",
        descripcion: "Starttime - El dato ingresado  no cumple con el patron HH:mm:ss.SZ.",
        tipo:'Excepción'
    },
    {
        codigo: "1073",
        descripcion: "StartTime - El dato ingresado no es valido.",
        tipo:'Excepción'
    },
    {
        codigo: "1074",
        descripcion: "cac:Shipment - El XML no contiene o no existe información en punto de llegada (cac:DeliveryAddress).",
        tipo:'Excepción'
    },
    {
        codigo: "1075",
        descripcion: "cac:Shipment - El XML no contiene o no existe información en punto de partida (cac:OriginAddress).",
        tipo:'Excepción'
    },
    {
        codigo: "1076",
        descripcion: "El XML no contiene el atributo o no existe información de sustento de traslado de mercaderias para el tipo de operación.",
        tipo:'Excepción'
    },
    {
        codigo: "1077",
        descripcion: "El XML contiene el tag de sustento de traslado de mercaderias que no corresponde al tipo de operación.",
        tipo:'Excepción'
    },
    {
        codigo: "1078",
        descripcion: "El emisor no se encuentra autorizado a emitir en el SEE-Desde los sistemas del contribuyente",
        tipo:'Excepción'
    },
    {
        codigo: "1079",
        descripcion: "Solo puede enviar el comprobante en un resumen diario",
        tipo:'Excepción'
    },
    {
        codigo: "1080",
        descripcion: "No puede enviar 'Recibos de servicios publicos' y sus notas asociadas por SEE-Desde los sistemas del contribuyente",
        tipo:'Excepción'
    },
    {
        codigo: "2010",
        descripcion: "El contribuyente no esta activo",
        tipo:'Rechazo'
    },
    {
        codigo: "2011",
        descripcion: "El contribuyente no esta habido",
        tipo:'Rechazo'
    },
    {
        codigo: "2012",
        descripcion: "El contribuyente no está autorizado a emitir comprobantes electrónicos",
        tipo:'Rechazo'
    },
    {
        codigo: "2013",
        descripcion: "El contribuyente no cumple con tipo de empresa o tributos requeridos",
        tipo:'Rechazo'
    },
    {
        codigo: "2014",
        descripcion: "El XML no contiene el tag o no existe informacion del número de documento de identidad del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2015",
        descripcion: "El XML no contiene el tag o no existe informacion del tipo de documento de identidad del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2016",
        descripcion: "El dato ingresado  en el tipo de documento de identidad del receptor no cumple con el estandar o no esta permitido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2017",
        descripcion: "El numero de documento de identidad del receptor debe ser  RUC",
        tipo:'Rechazo'
    },
    {
        codigo: "2018",
        descripcion: "El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2019",
        descripcion: "El XML no contiene el tag o no existe informacion de nombre o razon social del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2020",
        descripcion: "El nombre o razon social del emisor no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2021",
        descripcion: "El XML no contiene el tag o no existe informacion de RegistrationName del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2022",
        descripcion: "RegistrationName -  El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2023",
        descripcion: "El Numero de orden del item no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2024",
        descripcion: "El XML no contiene el tag InvoicedQuantity en el detalle de los Items o es cero (0)",
        tipo:'Rechazo'
    },
    {
        codigo: "2025",
        descripcion: "InvoicedQuantity El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2026",
        descripcion: "El XML no contiene el tag cac:Item/cbc:Description en el detalle de los Items",
        tipo:'Rechazo'
    },
    {
        codigo: "2027",
        descripcion: "El XML no contiene el tag o no existe informacion de cac:Item/cbc:Description del item",
        tipo:'Rechazo'
    },
    {
        codigo: "2028",
        descripcion: "Debe existir el tag cac:AlternativeConditionPrice",
        tipo:'Rechazo'
    },
    {
        codigo: "2029",
        descripcion: "PriceTypeCode El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2030",
        descripcion: "El XML no contiene el tag cbc:PriceTypeCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2031",
        descripcion: "El dato ingresado en total valor de venta no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2032",
        descripcion: "El XML no contiene el tag LineExtensionAmount en el detalle de los Items",
        tipo:'Rechazo'
    },
    {
        codigo: "2033",
        descripcion: "El dato ingresado en TaxAmount de la linea no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2034",
        descripcion: "TaxAmount es obligatorio",
        tipo:'Rechazo'
    },
    {
        codigo: "2035",
        descripcion: "cac:TaxCategory/cac:TaxScheme/cbc:ID El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2036",
        descripcion: "El codigo del tributo es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2037",
        descripcion: "El XML no contiene el tag cac:TaxCategory/cac:TaxScheme/cbc:ID del Item",
        tipo:'Rechazo'
    },
    {
        codigo: "2038",
        descripcion: "cac:TaxScheme/cbc:Name del item - No existe el tag o el dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2039",
        descripcion: "El XML no contiene el tag cac:TaxCategory/cac:TaxScheme/cbc:Name del Item",
        tipo:'Rechazo'
    },
    {
        codigo: "2040",
        descripcion: "El tipo de afectacion del IGV es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2041",
        descripcion: "El sistema de calculo del ISC es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2042",
        descripcion: "Debe indicar el IGV. Es un campo obligatorio",
        tipo:'Rechazo'
    },
    {
        codigo: "2043",
        descripcion: "El dato ingresado en PayableAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2044",
        descripcion: "PayableAmount es obligatorio",
        tipo:'Rechazo'
    },
    {
        codigo: "2045",
        descripcion: "El valor ingresado en AdditionalMonetaryTotal/cbc:ID es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2046",
        descripcion: "AdditionalMonetaryTotal/cbc:ID debe tener valor",
        tipo:'Rechazo'
    },
    {
        codigo: "2047",
        descripcion: "Es obligatorio al menos un AdditionalMonetaryTotal con codigo 1001, 1002, 1003 o 3001",
        tipo:'Rechazo'
    },
    {
        codigo: "2048",
        descripcion: "El dato ingresado en TaxAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2049",
        descripcion: "TaxAmount es obligatorio",
        tipo:'Rechazo'
    },
    {
        codigo: "2050",
        descripcion: "TaxScheme ID - No existe el tag o el dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2051",
        descripcion: "El codigo del tributo es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2052",
        descripcion: "El XML no contiene el tag código de tributo internacional de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2053",
        descripcion: "TaxScheme Name - No existe el tag o el dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2054",
        descripcion: "El XML no contiene el tag TaxScheme Name de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2055",
        descripcion: "TaxScheme TaxTypeCode - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2056",
        descripcion: "El XML no contiene el tag TaxScheme TaxTypeCode de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2057",
        descripcion: "El Name o TaxTypeCode debe corresponder con el Id para el IGV",
        tipo:'Rechazo'
    },
    {
        codigo: "2058",
        descripcion: "El Name o TaxTypeCode debe corresponder con el Id para el ISC",
        tipo:'Rechazo'
    },
    {
        codigo: "2059",
        descripcion: "El dato ingresado en TaxSubtotal/cbc:TaxAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2060",
        descripcion: "TaxSubtotal/cbc:TaxAmount es obligatorio",
        tipo:'Rechazo'
    },
    {
        codigo: "2061",
        descripcion: "El tag global cac:TaxTotal/cbc:TaxAmount debe tener el mismo valor que cac:TaxTotal/cac:Subtotal/cbc:TaxAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2062",
        descripcion: "El dato ingresado en PayableAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2063",
        descripcion: "El XML no contiene el tag PayableAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2064",
        descripcion: "El dato ingresado en ChargeTotalAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2065",
        descripcion: "El dato ingresado en el campo Total Descuentos no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2066",
        descripcion: "Debe indicar una descripcion para el tag sac:AdditionalProperty/cbc:Value",
        tipo:'Rechazo'
    },
    {
        codigo: "2067",
        descripcion: "cac:Price/cbc:PriceAmount - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2068",
        descripcion: "El XML no contiene el tag cac:Price/cbc:PriceAmount en el detalle de los Items",
        tipo:'Rechazo'
    },
    {
        codigo: "2069",
        descripcion: "DocumentCurrencyCode - El dato ingresado no cumple con la estructura",
        tipo:'Rechazo'
    },
    {
        codigo: "2070",
        descripcion: "El XML no contiene el tag o no existe informacion de DocumentCurrencyCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2071",
        descripcion: "La moneda debe ser la misma en todo el documento. Salvo las percepciones que sólo son en moneda nacional.",
        tipo:'Rechazo'
    },
    {
        codigo: "2072",
        descripcion: "CustomizationID - La versión del documento no es la correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2073",
        descripcion: "El XML no existe informacion de CustomizationID",
        tipo:'Rechazo'
    },
    {
        codigo: "2074",
        descripcion: "UBLVersionID - La versión del UBL no es correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2075",
        descripcion: "El XML no contiene el tag o no existe informacion de UBLVersionID",
        tipo:'Rechazo'
    },
    {
        codigo: "2076",
        descripcion: "cac:Signature/cbc:ID - Falta el identificador de la firma",
        tipo:'Rechazo'
    },
    {
        codigo: "2077",
        descripcion: "El tag cac:Signature/cbc:ID debe contener informacion",
        tipo:'Rechazo'
    },
    {
        codigo: "2078",
        descripcion: "cac:Signature/cac:SignatoryParty/ cac:PartyIdentification/cbc:ID - Debe ser igual al RUC del emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "2079",
        descripcion: "El XML no contiene el tag cac:Signature/cac:SignatoryParty/ cac:PartyIdentification/cbc:ID",
        tipo:'Rechazo'
    },
    {
        codigo: "2080",
        descripcion: "cac:Signature/cac:SignatoryParty/ cac:PartyName/cbc:Name - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2081",
        descripcion: "El XML no contiene el tag cac:Signature/cac:SignatoryParty/ cac:PartyName/cbc:Name",
        tipo:'Rechazo'
    },
    {
        codigo: "2082",
        descripcion: "cac:Signature/cac:DigitalSignatureAttachment/ cac:ExternalReference/cbc:URI - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2083",
        descripcion: "El XML no contiene el tag cac:Signature/cac:DigitalSignatureAttachment/ cac:ExternalReference/cbc:URI",
        tipo:'Rechazo'
    },
    {
        codigo: "2084",
        descripcion: "ext:UBLExtensions/ext:UBLExtension/ ext:ExtensionContent/ds:Signature/@Id - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2085",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/ext:UBLExtension/ ext:ExtensionContent/ds:Signature/@Id",
        tipo:'Rechazo'
    },
    {
        codigo: "2086",
        descripcion: "ext:UBLExtensions/.../ds:Signature/ds:SignedInfo/ ds:CanonicalizationMethod/@Algorithm - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2087",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/.../ ds:Signature/ds:SignedInfo/ ds:CanonicalizationMethod/@Algorithm",
        tipo:'Rechazo'
    },
    {
        codigo: "2088",
        descripcion: "ext:UBLExtensions/.../ds:Signature/ds:SignedInfo/ ds:SignatureMethod/@Algorithm - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2089",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/.../ ds:Signature/ds:SignedInfo/ ds:SignatureMethod/@Algorithm",
        tipo:'Rechazo'
    },
    {
        codigo: "2090",
        descripcion: "ext:UBLExtensions/.../ds:Signature/ ds:SignedInfo/ds:Reference/@URI - Debe estar vacio para id",
        tipo:'Rechazo'
    },
    {
        codigo: "2091",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/.../ ds:Signature/ds:SignedInfo/ds:Reference/@URI",
        tipo:'Rechazo'
    },
    {
        codigo: "2092",
        descripcion: "ext:UBLExtensions/.../ds:Signature/ ds:SignedInfo/.../ds:Transform@Algorithm - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2093",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/.../ ds:Signature/ds:SignedInfo/ ds:Reference/ds:Transform@Algorithm",
        tipo:'Rechazo'
    },
    {
        codigo: "2094",
        descripcion: "ext:UBLExtensions/.../ds:Signature/ds:SignedInfo/ ds:Reference/ds:DigestMethod/@Algorithm - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2095",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/.../ ds:Signature/ds:SignedInfo/ds:Reference/ ds:DigestMethod/@Algorithm",
        tipo:'Rechazo'
    },
    {
        codigo: "2096",
        descripcion: "ext:UBLExtensions/.../ds:Signature/ds:SignedInfo/ ds:Reference/ds:DigestValue - No  cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2097",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/.../ds:Signature/ ds:SignedInfo/ds:Reference/ds:DigestValue",
        tipo:'Rechazo'
    },
    {
        codigo: "2098",
        descripcion: "ext:UBLExtensions/.../ds:Signature/ ds:SignatureValue - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2099",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/.../ds:Signature/ ds:SignatureValue",
        tipo:'Rechazo'
    },
    {
        codigo: "2100",
        descripcion: "ext:UBLExtensions/.../ds:Signature/ds:KeyInfo/ ds:X509Data/ds:X509Certificate - No cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2101",
        descripcion: "El XML no contiene el tag ext:UBLExtensions/.../ds:Signature/ ds:KeyInfo/ds:X509Data/ds:X509Certificate",
        tipo:'Rechazo'
    },
    {
        codigo: "2102",
        descripcion: "Error al procesar la factura",
        tipo:'Rechazo'
    },
    {
        codigo: "2103",
        descripcion: "La serie ingresada no es válida",
        tipo:'Rechazo'
    },
    {
        codigo: "2104",
        descripcion: "Numero de RUC del emisor no existe",
        tipo:'Rechazo'
    },
    {
        codigo: "2105",
        descripcion: "Comprobante a dar de baja no se encuentra registrado en SUNAT",
        tipo:'Rechazo'
    },
    {
        codigo: "2106",
        descripcion: "Factura a dar de baja ya se encuentra en estado de baja",
        tipo:'Rechazo'
    },
    {
        codigo: "2107",
        descripcion: "Numero de RUC SOL no coincide con RUC emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "2108",
        descripcion: "Presentacion fuera de fecha",
        tipo:'Rechazo'
    },
    {
        codigo: "2109",
        descripcion: "El comprobante fue registrado previamente con otros datos",
        tipo:'Rechazo'
    },
    {
        codigo: "2110",
        descripcion: "UBLVersionID - La versión del UBL no es correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2111",
        descripcion: "El XML no contiene el tag o no existe informacion de UBLVersionID",
        tipo:'Rechazo'
    },
    {
        codigo: "2112",
        descripcion: "CustomizationID - La version del documento no es correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2113",
        descripcion: "El XML no contiene el tag o no existe informacion de CustomizationID",
        tipo:'Rechazo'
    },
    {
        codigo: "2114",
        descripcion: "DocumentCurrencyCode -  El dato ingresado no cumple con la estructura",
        tipo:'Rechazo'
    },
    {
        codigo: "2115",
        descripcion: "El XML no contiene el tag o no existe informacion de DocumentCurrencyCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2116",
        descripcion: "El tipo de documento modificado por la Nota de credito debe ser factura electronica o ticket",
        tipo:'Rechazo'
    },
    {
        codigo: "2117",
        descripcion: "La serie o numero del documento modificado por la Nota de Credito no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2118",
        descripcion: "Debe indicar las facturas relacionadas a la Nota de Credito",
        tipo:'Rechazo'
    },
    {
        codigo: "2119",
        descripcion: "El documento modificado en la Nota de credito no esta registrada.",
        tipo:'Rechazo'
    },
    {
        codigo: "2120",
        descripcion: "El documento modificado en la Nota de credito se encuentra de baja",
        tipo:'Rechazo'
    },
    {
        codigo: "2121",
        descripcion: "El documento modificado en la Nota de credito esta registrada como rechazada",
        tipo:'Rechazo'
    },
    {
        codigo: "2122",
        descripcion: "El tag cac:LegalMonetaryTotal/cbc:PayableAmount debe tener informacion valida",
        tipo:'Rechazo'
    },
    {
        codigo: "2123",
        descripcion: "RegistrationName -  El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2124",
        descripcion: "El XML no contiene el tag RegistrationName del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2125",
        descripcion: "ReferenceID -  El dato ingresado debe indicar SERIE-CORRELATIVO del documento al que se relaciona la Nota",
        tipo:'Rechazo'
    },
    {
        codigo: "2126",
        descripcion: "El XML no contiene informacion en el tag ReferenceID del documento al que se relaciona la nota",
        tipo:'Rechazo'
    },
    {
        codigo: "2127",
        descripcion: "ResponseCode -  El dato ingresado no cumple  con  la  estructura",
        tipo:'Rechazo'
    },
    {
        codigo: "2128",
        descripcion: "El XML no contiene el tag o no existe informacion de ResponseCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2129",
        descripcion: "AdditionalAccountID -  El dato ingresado  en el tipo de documento de identidad del receptor no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2130",
        descripcion: "El XML no contiene el tag o no existe informacion de AdditionalAccountID del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2131",
        descripcion: "CustomerAssignedAccountID - El numero de documento de identidad del receptor debe ser RUC",
        tipo:'Rechazo'
    },
    {
        codigo: "2132",
        descripcion: "El XML no contiene el tag o no existe informacion de CustomerAssignedAccountID del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2133",
        descripcion: "RegistrationName -  El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2134",
        descripcion: "El XML no contiene el tag o no existe informacion de RegistrationName del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2135",
        descripcion: "cac:DiscrepancyResponse/cbc:Description - El dato ingresado no cumple con la estructura",
        tipo:'Rechazo'
    },
    {
        codigo: "2136",
        descripcion: "El XML no contiene el tag o no existe informacion de cac:DiscrepancyResponse/cbc:Description",
        tipo:'Rechazo'
    },
    {
        codigo: "2137",
        descripcion: "El Numero de orden del item no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2138",
        descripcion: "CreditedQuantity/@unitCode - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2139",
        descripcion: "CreditedQuantity - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2140",
        descripcion: "El PriceTypeCode debe tener el valor 01",
        tipo:'Rechazo'
    },
    {
        codigo: "2141",
        descripcion: "cac:TaxCategory/cac:TaxScheme/cbc:ID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2142",
        descripcion: "El codigo del tributo es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2143",
        descripcion: "cac:TaxScheme/cbc:Name del item - No existe el tag o el dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2144",
        descripcion: "cac:TaxCategory/cac:TaxScheme/cbc:TaxTypeCode El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2145",
        descripcion: "El tipo de afectacion del IGV es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2146",
        descripcion: "El Nombre Internacional debe ser VAT",
        tipo:'Rechazo'
    },
    {
        codigo: "2147",
        descripcion: "El sistema de calculo del ISC es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2148",
        descripcion: "El Nombre Internacional debe ser EXC",
        tipo:'Rechazo'
    },
    {
        codigo: "2149",
        descripcion: "El dato ingresado en PayableAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2150",
        descripcion: "El valor ingresado en AdditionalMonetaryTotal/cbc:ID es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2151",
        descripcion: "AdditionalMonetaryTotal/cbc:ID debe tener valor",
        tipo:'Rechazo'
    },
    {
        codigo: "2152",
        descripcion: "Es obligatorio al menos un AdditionalInformation",
        tipo:'Rechazo'
    },
    {
        codigo: "2153",
        descripcion: "Error al procesar la Nota de Credito",
        tipo:'Rechazo'
    },
    {
        codigo: "2154",
        descripcion: "TaxAmount - El dato ingresado en impuestos globales no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2155",
        descripcion: "El XML no contiene el tag TaxAmount de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2156",
        descripcion: "TaxScheme ID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2157",
        descripcion: "El codigo del tributo es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2158",
        descripcion: "El XML no contiene el tag o no existe informacion de TaxScheme ID de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2159",
        descripcion: "TaxScheme Name - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2160",
        descripcion: "El XML no contiene el tag o no existe informacion de TaxScheme Name de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2161",
        descripcion: "CustomizationID - La version del documento no es correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2162",
        descripcion: "El XML no contiene el tag o no existe informacion de CustomizationID",
        tipo:'Rechazo'
    },
    {
        codigo: "2163",
        descripcion: "UBLVersionID - La versión del UBL no es correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2164",
        descripcion: "El XML no contiene el tag o no existe informacion de UBLVersionID",
        tipo:'Rechazo'
    },
    {
        codigo: "2165",
        descripcion: "Error al procesar la Nota de Debito",
        tipo:'Rechazo'
    },
    {
        codigo: "2166",
        descripcion: "RegistrationName - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2167",
        descripcion: "El XML no contiene el tag RegistrationName del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2168",
        descripcion: "DocumentCurrencyCode -  El dato ingresado no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2169",
        descripcion: "El XML no contiene el tag o no existe informacion de DocumentCurrencyCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2170",
        descripcion: "ReferenceID - El dato ingresado debe indicar SERIE-CORRELATIVO del documento al que se relaciona la Nota",
        tipo:'Rechazo'
    },
    {
        codigo: "2171",
        descripcion: "El XML no contiene informacion en el tag ReferenceID del documento al que se relaciona la nota",
        tipo:'Rechazo'
    },
    {
        codigo: "2172",
        descripcion: "ResponseCode - El dato ingresado no cumple con la estructura",
        tipo:'Rechazo'
    },
    {
        codigo: "2173",
        descripcion: "El XML no contiene el tag o no existe informacion de ResponseCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2174",
        descripcion: "cac:DiscrepancyResponse/cbc:Description - El dato ingresado no cumple con la estructura",
        tipo:'Rechazo'
    },
    {
        codigo: "2175",
        descripcion: "El XML no contiene el tag o no existe informacion de cac:DiscrepancyResponse/cbc:Description",
        tipo:'Rechazo'
    },
    {
        codigo: "2176",
        descripcion: "AdditionalAccountID -  El dato ingresado  en el tipo de documento de identidad del receptor no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2177",
        descripcion: "El XML no contiene el tag o no existe informacion de AdditionalAccountID del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2178",
        descripcion: "CustomerAssignedAccountID - El numero de documento de identidad del receptor debe ser RUC.",
        tipo:'Rechazo'
    },
    {
        codigo: "2179",
        descripcion: "El XML no contiene el tag o no existe informacion de CustomerAssignedAccountID del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2180",
        descripcion: "RegistrationName - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2181",
        descripcion: "El XML no contiene el tag o no existe informacion de RegistrationName del receptor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2182",
        descripcion: "TaxScheme ID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2183",
        descripcion: "El codigo del tributo es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2184",
        descripcion: "El XML no contiene el tag o no existe informacion de TaxScheme ID de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2185",
        descripcion: "TaxScheme Name - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2186",
        descripcion: "El XML no contiene el tag o no existe informacion de TaxScheme Name de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2187",
        descripcion: "El Numero de orden del item no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2188",
        descripcion: "DebitedQuantity/@unitCode El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2189",
        descripcion: "DebitedQuantity El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2190",
        descripcion: "El XML no contiene el tag Price/cbc:PriceAmount en el detalle de los Items",
        tipo:'Rechazo'
    },
    {
        codigo: "2191",
        descripcion: "El XML no contiene el tag Price/cbc:LineExtensionAmount en el detalle de los Items",
        tipo:'Rechazo'
    },
    {
        codigo: "2192",
        descripcion: "EL PriceTypeCode debe tener el valor 01",
        tipo:'Rechazo'
    },
    {
        codigo: "2193",
        descripcion: "cac:TaxCategory/cac:TaxScheme/cbc:ID El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2194",
        descripcion: "El codigo del tributo es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2195",
        descripcion: "cac:TaxScheme/cbc:Name del item - No existe el tag o el dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2196",
        descripcion: "cac:TaxCategory/cac:TaxScheme/cbc:TaxTypeCode El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2197",
        descripcion: "El tipo de afectacion del IGV es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2198",
        descripcion: "El Nombre Internacional debe ser VAT",
        tipo:'Rechazo'
    },
    {
        codigo: "2199",
        descripcion: "El sistema de calculo del ISC es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2200",
        descripcion: "El Nombre Internacional debe ser EXC",
        tipo:'Rechazo'
    },
    {
        codigo: "2201",
        descripcion: "El tag cac:RequestedMonetaryTotal/cbc:PayableAmount debe tener informacion valida",
        tipo:'Rechazo'
    },
    {
        codigo: "2202",
        descripcion: "TaxAmount - El dato ingresado en impuestos globales no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2203",
        descripcion: "El XML no contiene el tag TaxAmount de impuestos globales",
        tipo:'Rechazo'
    },
    {
        codigo: "2204",
        descripcion: "El tipo de documento modificado por la Nota de Debito debe ser factura electronica, ticket o documento autorizado",
        tipo:'Rechazo'
    },
    {
        codigo: "2205",
        descripcion: "La serie o numero del documento modificado por la Nota de Debito no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2206",
        descripcion: "Debe indicar los documentos afectados por la Nota de Debito",
        tipo:'Rechazo'
    },
    {
        codigo: "2207",
        descripcion: "El documento modificado en la Nota de debito se encuentra de baja",
        tipo:'Rechazo'
    },
    {
        codigo: "2208",
        descripcion: "El documento modificado en la Nota de debito esta registrada como rechazada",
        tipo:'Rechazo'
    },
    {
        codigo: "2209",
        descripcion: "El documento modificado en la Nota de debito no esta registrada",
        tipo:'Rechazo'
    },
    {
        codigo: "2210",
        descripcion: "El dato ingresado no cumple con el formato RC-fecha-correlativo",
        tipo:'Rechazo'
    },
    {
        codigo: "2211",
        descripcion: "El XML no contiene el tag ID",
        tipo:'Rechazo'
    },
    {
        codigo: "2212",
        descripcion: "UBLVersionID - La versión del UBL del resumen de boletas no es correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2213",
        descripcion: "El XML no contiene el tag UBLVersionID",
        tipo:'Rechazo'
    },
    {
        codigo: "2214",
        descripcion: "CustomizationID - La versión del resumen de boletas no es correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2215",
        descripcion: "El XML no contiene el tag CustomizationID",
        tipo:'Rechazo'
    },
    {
        codigo: "2216",
        descripcion: "CustomerAssignedAccountID -  El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2217",
        descripcion: "El XML no contiene el tag CustomerAssignedAccountID del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2218",
        descripcion: "AdditionalAccountID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2219",
        descripcion: "El XML no contiene el tag AdditionalAccountID del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2220",
        descripcion: "El ID debe coincidir con el nombre del archivo",
        tipo:'Rechazo'
    },
    {
        codigo: "2221",
        descripcion: "El RUC debe coincidir con el RUC del nombre del archivo",
        tipo:'Rechazo'
    },
    {
        codigo: "2222",
        descripcion: "El contribuyente no está autorizado a emitir comprobantes electronicos",
        tipo:'Rechazo'
    },
    {
        codigo: "2223",
        descripcion: "El archivo ya fue presentado anteriormente",
        tipo:'Rechazo'
    },
    {
        codigo: "2224",
        descripcion: "Numero de RUC SOL no coincide con RUC emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "2225",
        descripcion: "Numero de RUC del emisor no existe",
        tipo:'Rechazo'
    },
    {
        codigo: "2226",
        descripcion: "El contribuyente no esta activo",
        tipo:'Rechazo'
    },
    {
        codigo: "2227",
        descripcion: "El contribuyente no cumple con tipo de empresa o tributos requeridos",
        tipo:'Rechazo'
    },
    {
        codigo: "2228",
        descripcion: "RegistrationName - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2229",
        descripcion: "El XML no contiene el tag RegistrationName del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2230",
        descripcion: "IssueDate - El dato ingresado no cumple con el patron YYYY-MM-DD",
        tipo:'Rechazo'
    },
    {
        codigo: "2231",
        descripcion: "El XML no contiene el tag IssueDate",
        tipo:'Rechazo'
    },
    {
        codigo: "2232",
        descripcion: "IssueDate- El dato ingresado no es valido",
        tipo:'Rechazo'
    },
    {
        codigo: "2233",
        descripcion: "ReferenceDate - El dato ingresado no cumple con el patron YYYY-MM-DD",
        tipo:'Rechazo'
    },
    {
        codigo: "2234",
        descripcion: "El XML no contiene el tag ReferenceDate",
        tipo:'Rechazo'
    },
    {
        codigo: "2235",
        descripcion: "ReferenceDate- El dato ingresado no es valido",
        tipo:'Rechazo'
    },
    {
        codigo: "2236",
        descripcion: "La fecha del IssueDate no debe ser mayor a la fecha de recepción",
        tipo:'Rechazo'
    },
    {
        codigo: "2237",
        descripcion: "La fecha del ReferenceDate no debe ser mayor al Today",
        tipo:'Rechazo'
    },
    {
        codigo: "2238",
        descripcion: "LineID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2239",
        descripcion: "LineID - El dato ingresado debe ser correlativo mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2240",
        descripcion: "El XML no contiene el tag LineID de SummaryDocumentsLine",
        tipo:'Rechazo'
    },
    {
        codigo: "2241",
        descripcion: "DocumentTypeCode - El valor del tipo de documento es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2242",
        descripcion: "El XML no contiene el tag DocumentTypeCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2243",
        descripcion: "El dato ingresado  no cumple con el patron SERIE",
        tipo:'Rechazo'
    },
    {
        codigo: "2244",
        descripcion: "El XML no contiene el tag DocumentSerialID",
        tipo:'Rechazo'
    },
    {
        codigo: "2245",
        descripcion: "El dato ingresado en StartDocumentNumberID debe ser numerico",
        tipo:'Rechazo'
    },
    {
        codigo: "2246",
        descripcion: "El XML no contiene el tag StartDocumentNumberID",
        tipo:'Rechazo'
    },
    {
        codigo: "2247",
        descripcion: "El dato ingresado en sac:EndDocumentNumberID debe ser numerico",
        tipo:'Rechazo'
    },
    {
        codigo: "2248",
        descripcion: "El XML no contiene el tag sac:EndDocumentNumberID",
        tipo:'Rechazo'
    },
    {
        codigo: "2249",
        descripcion: "Los rangos deben ser mayores a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2250",
        descripcion: "En el rango de comprobantes, el EndDocumentNumberID debe ser mayor o igual al StartInvoiceNumberID",
        tipo:'Rechazo'
    },
    {
        codigo: "2251",
        descripcion: "El dato ingresado en TotalAmount debe ser numerico mayor o igual a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2252",
        descripcion: "El XML no contiene el tag TotalAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2253",
        descripcion: "El dato ingresado en TotalAmount debe ser numerico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2254",
        descripcion: "PaidAmount - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2255",
        descripcion: "El XML no contiene el tag PaidAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2256",
        descripcion: "InstructionID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2257",
        descripcion: "El XML no contiene el tag InstructionID",
        tipo:'Rechazo'
    },
    {
        codigo: "2258",
        descripcion: "Debe indicar Referencia de Importes asociados a las boletas de venta",
        tipo:'Rechazo'
    },
    {
        codigo: "2259",
        descripcion: "Debe indicar 3 Referencias de Importes asociados a las boletas de venta",
        tipo:'Rechazo'
    },
    {
        codigo: "2260",
        descripcion: "PaidAmount - El dato ingresado debe ser mayor o igual a 0.00",
        tipo:'Rechazo'
    },
    {
        codigo: "2261",
        descripcion: "cbc:Amount - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2262",
        descripcion: "El XML no contiene el tag cbc:Amount",
        tipo:'Rechazo'
    },
    {
        codigo: "2263",
        descripcion: "ChargeIndicator - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2264",
        descripcion: "El XML no contiene el tag ChargeIndicator",
        tipo:'Rechazo'
    },
    {
        codigo: "2265",
        descripcion: "Debe indicar Información acerca del Importe Total de Otros Cargos",
        tipo:'Rechazo'
    },
    {
        codigo: "2266",
        descripcion: "Debe indicar cargos mayores o iguales a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2267",
        descripcion: "TaxScheme ID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2268",
        descripcion: "El codigo del tributo es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2269",
        descripcion: "El XML no contiene el tag TaxScheme ID de Información acerca del importe total de un tipo particular de impuesto",
        tipo:'Rechazo'
    },
    {
        codigo: "2270",
        descripcion: "TaxScheme Name - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2271",
        descripcion: "El XML no contiene el tag TaxScheme Name de impuesto",
        tipo:'Rechazo'
    },
    {
        codigo: "2272",
        descripcion: "TaxScheme TaxTypeCode - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2273",
        descripcion: "TaxAmount - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2274",
        descripcion: "El XML no contiene el tag TaxAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2275",
        descripcion: "Si el codigo de tributo es 2000, el nombre del tributo debe ser ISC",
        tipo:'Rechazo'
    },
    {
        codigo: "2276",
        descripcion: "Si el codigo de tributo es 1000, el nombre del tributo debe ser IGV",
        tipo:'Rechazo'
    },
    {
        codigo: "2277",
        descripcion: "No se ha consignado ninguna informacion del importe total de tributos",
        tipo:'Rechazo'
    },
    {
        codigo: "2278",
        descripcion: "Debe indicar Información acerca del importe total de IGV/IVAP",
        tipo:'Rechazo'
    },
    {
        codigo: "2279",
        descripcion: "Debe indicar Items de consolidado de documentos",
        tipo:'Rechazo'
    },
    {
        codigo: "2280",
        descripcion: "Existen problemas con la informacion del resumen de comprobantes",
        tipo:'Rechazo'
    },
    {
        codigo: "2281",
        descripcion: "Error en la validacion de los rangos de los comprobantes",
        tipo:'Rechazo'
    },
    {
        codigo: "2282",
        descripcion: "Existe documento ya informado anteriormente",
        tipo:'Rechazo'
    },
    {
        codigo: "2283",
        descripcion: "El dato ingresado no cumple con el formato RA-fecha-correlativo",
        tipo:'Rechazo'
    },
    {
        codigo: "2284",
        descripcion: "El tag ID esta vacío",
        tipo:'Rechazo'
    },
    {
        codigo: "2285",
        descripcion: "El ID debe coincidir  con el nombre del archivo",
        tipo:'Rechazo'
    },
    {
        codigo: "2286",
        descripcion: "El RUC debe coincidir con el RUC del nombre del archivo",
        tipo:'Rechazo'
    },
    {
        codigo: "2287",
        descripcion: "AdditionalAccountID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2288",
        descripcion: "El XML no contiene el tag AdditionalAccountID del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2289",
        descripcion: "CustomerAssignedAccountID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2290",
        descripcion: "El XML no contiene el tag CustomerAssignedAccountID del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2291",
        descripcion: "El contribuyente no esta autorizado a emitir comprobantes electronicos",
        tipo:'Rechazo'
    },
    {
        codigo: "2292",
        descripcion: "Numero de RUC SOL no coincide con RUC emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "2293",
        descripcion: "Numero de RUC del emisor no existe",
        tipo:'Rechazo'
    },
    {
        codigo: "2294",
        descripcion: "El contribuyente no esta activo",
        tipo:'Rechazo'
    },
    {
        codigo: "2295",
        descripcion: "El contribuyente no cumple con tipo de empresa o tributos requeridos",
        tipo:'Rechazo'
    },
    {
        codigo: "2296",
        descripcion: "RegistrationName - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2297",
        descripcion: "El XML no contiene el tag RegistrationName del emisor del documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2298",
        descripcion: "IssueDate - El dato ingresado no cumple con el patron YYYY-MM-DD",
        tipo:'Rechazo'
    },
    {
        codigo: "2299",
        descripcion: "El XML no contiene el tag IssueDate",
        tipo:'Rechazo'
    },
    {
        codigo: "2300",
        descripcion: "IssueDate - El dato ingresado no es valido",
        tipo:'Rechazo'
    },
    {
        codigo: "2301",
        descripcion: "La fecha del IssueDate no debe ser mayor a la fecha de recepción",
        tipo:'Rechazo'
    },
    {
        codigo: "2302",
        descripcion: "ReferenceDate - El dato ingresado no cumple con el patron YYYY-MM-DD",
        tipo:'Rechazo'
    },
    {
        codigo: "2303",
        descripcion: "El XML no contiene el tag ReferenceDate",
        tipo:'Rechazo'
    },
    {
        codigo: "2304",
        descripcion: "ReferenceDate - El dato ingresado no es valido",
        tipo:'Rechazo'
    },
    {
        codigo: "2305",
        descripcion: "LineID - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2306",
        descripcion: "LineID - El dato ingresado debe ser correlativo mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2307",
        descripcion: "El tag LineID de VoidedDocumentsLine esta vacío",
        tipo:'Rechazo'
    },
    {
        codigo: "2308",
        descripcion: "DocumentTypeCode - El valor del tipo de documento es invalido",
        tipo:'Rechazo'
    },
    {
        codigo: "2309",
        descripcion: "El tag DocumentTypeCode es vacío",
        tipo:'Rechazo'
    },
    {
        codigo: "2310",
        descripcion: "El dato ingresado  no cumple con el patron SERIE",
        tipo:'Rechazo'
    },
    {
        codigo: "2311",
        descripcion: "El tag DocumentSerialID es vacío",
        tipo:'Rechazo'
    },
    {
        codigo: "2312",
        descripcion: "El dato ingresado en DocumentNumberID debe ser numerico y como maximo de 8 digitos",
        tipo:'Rechazo'
    },
    {
        codigo: "2313",
        descripcion: "El tag DocumentNumberID esta vacío",
        tipo:'Rechazo'
    },
    {
        codigo: "2314",
        descripcion: "El dato ingresado en VoidReasonDescription debe contener información válida",
        tipo:'Rechazo'
    },
    {
        codigo: "2315",
        descripcion: "El tag VoidReasonDescription esta vacío",
        tipo:'Rechazo'
    },
    {
        codigo: "2316",
        descripcion: "Debe indicar Items en VoidedDocumentsLine",
        tipo:'Rechazo'
    },
    {
        codigo: "2317",
        descripcion: "Error al procesar el resumen de anulados",
        tipo:'Rechazo'
    },
    {
        codigo: "2318",
        descripcion: "CustomizationID - La version del documento no es correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2319",
        descripcion: "El XML no contiene el tag CustomizationID",
        tipo:'Rechazo'
    },
    {
        codigo: "2320",
        descripcion: "UBLVersionID - La version del UBL  no es la correcta",
        tipo:'Rechazo'
    },
    {
        codigo: "2321",
        descripcion: "El XML no contiene el tag UBLVersionID",
        tipo:'Rechazo'
    },
    {
        codigo: "2322",
        descripcion: "Error en la validacion de los rangos",
        tipo:'Rechazo'
    },
    {
        codigo: "2323",
        descripcion: "Existe documento ya informado anteriormente en una comunicacion de baja",
        tipo:'Rechazo'
    },
    {
        codigo: "2324",
        descripcion: "El archivo de comunicacion de baja ya fue presentado anteriormente",
        tipo:'Rechazo'
    },
    {
        codigo: "2325",
        descripcion: "El certificado usado no es el comunicado a SUNAT",
        tipo:'Rechazo'
    },
    {
        codigo: "2326",
        descripcion: "El certificado usado se encuentra de baja",
        tipo:'Rechazo'
    },
    {
        codigo: "2327",
        descripcion: "El certificado usado no se encuentra vigente",
        tipo:'Rechazo'
    },
    {
        codigo: "2328",
        descripcion: "El certificado usado se encuentra revocado",
        tipo:'Rechazo'
    },
    {
        codigo: "2329",
        descripcion: "La fecha de emision se encuentra fuera del limite permitido",
        tipo:'Rechazo'
    },
    {
        codigo: "2330",
        descripcion: "La fecha de generación de la comunicación debe ser igual a la fecha consignada en el nombre del archivo",
        tipo:'Rechazo'
    },
    {
        codigo: "2331",
        descripcion: "Número de RUC del nombre del archivo no coincide con el consignado en el contenido del archivo XML",
        tipo:'Rechazo'
    },
    {
        codigo: "2332",
        descripcion: "Número de Serie del nombre del archivo no coincide con el consignado en el contenido del archivo XML",
        tipo:'Rechazo'
    },
    {
        codigo: "2333",
        descripcion: "Número de documento en el nombre del archivo no coincide con el consignado en el contenido del XML",
        tipo:'Rechazo'
    },
    {
        codigo: "2334",
        descripcion: "El documento electrónico ingresado ha sido alterado",
        tipo:'Rechazo'
    },
    {
        codigo: "2335",
        descripcion: "El documento electrónico ingresado ha sido alterado",
        tipo:'Rechazo'
    },
    {
        codigo: "2336",
        descripcion: "Ocurrió un error en el proceso de validación de la firma digital",
        tipo:'Rechazo'
    },
    {
        codigo: "2337",
        descripcion: "La moneda debe ser la misma en todo el documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2338",
        descripcion: "La moneda debe ser la misma en todo el documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2339",
        descripcion: "El dato ingresado en PayableAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2340",
        descripcion: "El valor ingresado en AdditionalMonetaryTotal/cbc:ID es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2341",
        descripcion: "AdditionalMonetaryTotal/cbc:ID debe tener valor",
        tipo:'Rechazo'
    },
    {
        codigo: "2342",
        descripcion: "Fecha de emision de la factura no coincide con la informada en la comunicacion",
        tipo:'Rechazo'
    },
    {
        codigo: "2343",
        descripcion: "cac:TaxTotal/cac:TaxSubtotal/cbc:TaxAmount - El dato ingresado no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2344",
        descripcion: "El XML no contiene el tag cac:TaxTotal/cac:TaxSubtotal/cbc:TaxAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2345",
        descripcion: "La serie no corresponde al tipo de comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2346",
        descripcion: "La fecha de generación del resumen debe ser igual a la fecha consignada en el nombre del archivo",
        tipo:'Rechazo'
    },
    {
        codigo: "2347",
        descripcion: "Los rangos informados en el archivo XML se encuentran duplicados o superpuestos",
        tipo:'Rechazo'
    },
    {
        codigo: "2348",
        descripcion: "Los documentos informados en el archivo XML se encuentran duplicados",
        tipo:'Rechazo'
    },
    {
        codigo: "2349",
        descripcion: "Debe consignar solo un elemento sac:AdditionalMonetaryTotal con cbc:ID igual a 1001",
        tipo:'Rechazo'
    },
    {
        codigo: "2350",
        descripcion: "Debe consignar solo un elemento sac:AdditionalMonetaryTotal con cbc:ID igual a 1002",
        tipo:'Rechazo'
    },
    {
        codigo: "2351",
        descripcion: "Debe consignar solo un elemento sac:AdditionalMonetaryTotal con cbc:ID igual a 1003",
        tipo:'Rechazo'
    },
    {
        codigo: "2352",
        descripcion: "Debe consignar solo un elemento cac:TaxTotal a nivel global para IGV (cbc:ID igual a 1000)",
        tipo:'Rechazo'
    },
    {
        codigo: "2353",
        descripcion: "Debe consignar solo un elemento cac:TaxTotal a nivel global para ISC (cbc:ID igual a 2000)",
        tipo:'Rechazo'
    },
    {
        codigo: "2354",
        descripcion: "Debe consignar solo un elemento cac:TaxTotal a nivel global para Otros (cbc:ID igual a 9999)",
        tipo:'Rechazo'
    },
    {
        codigo: "2355",
        descripcion: "Debe consignar solo un elemento cac:TaxTotal a nivel de item por codigo de tributo",
        tipo:'Rechazo'
    },
    {
        codigo: "2356",
        descripcion: "Debe consignar solo un elemento cac:TaxTotal a nivel de item para ISC (cbc:ID igual a 2000)",
        tipo:'Rechazo'
    },
    {
        codigo: "2357",
        descripcion: "No debe existir un elemento sac:BillingPayment a nivel de item con el mismo valor de cbc:InstructionID",
        tipo:'Rechazo'
    },
    {
        codigo: "2358",
        descripcion: "Debe consignar solo un elemento sac:BillingPayment a nivel de item con cbc:InstructionID igual a 02",
        tipo:'Rechazo'
    },
    {
        codigo: "2359",
        descripcion: "Debe consignar solo un elemento sac:BillingPayment a nivel de item con cbc:InstructionID igual a 03",
        tipo:'Rechazo'
    },
    {
        codigo: "2360",
        descripcion: "Debe consignar solo un elemento sac:BillingPayment a nivel de item con cbc:InstructionID igual a 04",
        tipo:'Rechazo'
    },
    {
        codigo: "2361",
        descripcion: "Debe consignar solo un elemento cac:TaxTotal a nivel de item para Otros (cbc:ID igual a 9999)",
        tipo:'Rechazo'
    },
    {
        codigo: "2362",
        descripcion: "Debe consignar solo un tag cac:AccountingSupplierParty/ cbc:AdditionalAccountID",
        tipo:'Rechazo'
    },
    {
        codigo: "2363",
        descripcion: "Debe consignar solo un tag cac:AccountingCustomerParty/ cbc:AdditionalAccountID",
        tipo:'Rechazo'
    },
    {
        codigo: "2364",
        descripcion: "El comprobante contiene un tipo y número de Guía de Remisión repetido",
        tipo:'Rechazo'
    },
    {
        codigo: "2365",
        descripcion: "El comprobante contiene un tipo y número de Documento Relacionado repetido",
        tipo:'Rechazo'
    },
    {
        codigo: "2366",
        descripcion: "El codigo en el tag sac:AdditionalProperty/cbc:ID debe tener 4 posiciones",
        tipo:'Rechazo'
    },
    {
        codigo: "2367",
        descripcion: "El dato ingresado en PriceAmount del Precio de venta unitario por item no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2368",
        descripcion: "El dato ingresado en TaxSubtotal/cbc:TaxAmount del item no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2369",
        descripcion: "El dato ingresado en PriceAmount del Valor de venta unitario por item no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2370",
        descripcion: "El dato ingresado en LineExtensionAmount del item no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2371",
        descripcion: "El XML no contiene el tag cbc:TaxExemptionReasonCode de Afectacion al IGV",
        tipo:'Rechazo'
    },
    {
        codigo: "2372",
        descripcion: "El tag en el item cac:TaxTotal/cbc:TaxAmount debe tener el mismo valor que cac:TaxTotal/cac:TaxSubtotal/cbc:TaxAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2373",
        descripcion: "Si existe monto de ISC en el ITEM debe especificar el sistema de calculo",
        tipo:'Rechazo'
    },
    {
        codigo: "2374",
        descripcion: "La factura a dar de baja tiene una fecha de recepcion fuera del plazo permitido",
        tipo:'Rechazo'
    },
    {
        codigo: "2375",
        descripcion: "Fecha de emision del comprobante no coincide con la fecha de emision consignada en la comunicación",
        tipo:'Rechazo'
    },
    {
        codigo: "2376",
        descripcion: "La boleta de venta a dar de baja fue informada en un resumen con fecha de recepcion fuera del plazo permitido",
        tipo:'Rechazo'
    },
    {
        codigo: "2377",
        descripcion: "El Name o TaxTypeCode debe corresponder al codigo de tributo del item",
        tipo:'Rechazo'
    },
    {
        codigo: "2378",
        descripcion: "El Name o TaxTypeCode debe corresponder con el Id para el ISC",
        tipo:'Rechazo'
    },
    {
        codigo: "2379",
        descripcion: "La numeracion de boleta de venta a dar de baja fue generada en una fecha fuera del plazo permitido",
        tipo:'Rechazo'
    },
    {
        codigo: "2380",
        descripcion: "El documento tiene observaciones",
        tipo:'Rechazo'
    },
    {
        codigo: "2381",
        descripcion: "Comprobante no cumple con el Grupo 1: No todos los items corresponden a operaciones gravadas a IGV",
        tipo:'Rechazo'
    },
    {
        codigo: "2382",
        descripcion: "Comprobante no cumple con el Grupo 2: No todos los items corresponden a operaciones inafectas o exoneradas al IGV",
        tipo:'Rechazo'
    },
    {
        codigo: "2383",
        descripcion: "Comprobante no cumple con el Grupo 3: Falta leyenda con codigo 1002",
        tipo:'Rechazo'
    },
    {
        codigo: "2384",
        descripcion: "Comprobante no cumple con el Grupo 3: Existe item con operación onerosa",
        tipo:'Rechazo'
    },
    {
        codigo: "2385",
        descripcion: "Comprobante no cumple con el Grupo 4: Debe exitir Total descuentos mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2386",
        descripcion: "Comprobante no cumple con el Grupo 5: Todos los items deben tener operaciones afectas a ISC",
        tipo:'Rechazo'
    },
    {
        codigo: "2387",
        descripcion: "Comprobante no cumple con el Grupo 6: El monto de percepcion no existe o es cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2388",
        descripcion: "Comprobante no cumple con el Grupo 6: Todos los items deben tener código de Afectación al IGV igual a 10",
        tipo:'Rechazo'
    },
    {
        codigo: "2389",
        descripcion: "Comprobante no cumple con el Grupo 7: El codigo de moneda no es diferente a PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2390",
        descripcion: "Comprobante no cumple con el Grupo 8: No todos los items corresponden a operaciones gravadas a IGV",
        tipo:'Rechazo'
    },
    {
        codigo: "2391",
        descripcion: "Comprobante no cumple con el Grupo 9: No todos los items corresponden a operaciones inafectas o exoneradas al IGV",
        tipo:'Rechazo'
    },
    {
        codigo: "2392",
        descripcion: "Comprobante no cumple con el Grupo 10: Falta leyenda con codigo 1002",
        tipo:'Rechazo'
    },
    {
        codigo: "2393",
        descripcion: "Comprobante no cumple con el Grupo 10: Existe item con operación onerosa",
        tipo:'Rechazo'
    },
    {
        codigo: "2394",
        descripcion: "Comprobante no cumple con el Grupo 11: Debe existir Total descuentos mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2395",
        descripcion: "Comprobante no cumple con el Grupo 12: El codigo de moneda no es diferente a PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2396",
        descripcion: "Si el monto total es mayor a S/. 700.00 debe consignar tipo y numero de documento del adquiriente",
        tipo:'Rechazo'
    },
    {
        codigo: "2397",
        descripcion: "El tipo de documento del adquiriente no puede ser Numero de RUC",
        tipo:'Rechazo'
    },
    {
        codigo: "2398",
        descripcion: "El documento a dar de baja se encuentra rechazado",
        tipo:'Rechazo'
    },
    {
        codigo: "2399",
        descripcion: "El tipo de documento modificado por la Nota de credito debe ser boleta electronica",
        tipo:'Rechazo'
    },
    {
        codigo: "2400",
        descripcion: "El tipo de documento modificado por la Nota de debito debe ser boleta electronica",
        tipo:'Rechazo'
    },
    {
        codigo: "2401",
        descripcion: "No se puede leer (parsear) el archivo XML",
        tipo:'Rechazo'
    },
    {
        codigo: "2402",
        descripcion: "El caso de prueba no existe",
        tipo:'Rechazo'
    },
    {
        codigo: "2403",
        descripcion: "La numeracion o nombre del documento ya ha sido enviado anteriormente",
        tipo:'Rechazo'
    },
    {
        codigo: "2404",
        descripcion: "Documento afectado por la nota electronica no se encuentra autorizado",
        tipo:'Rechazo'
    },
    {
        codigo: "2405",
        descripcion: "Contribuyente no se encuentra autorizado como emisor de boletas electronicas",
        tipo:'Rechazo'
    },
    {
        codigo: "2406",
        descripcion: "Existe mas de un tag sac:AdditionalMonetaryTotal con el mismo ID",
        tipo:'Rechazo'
    },
    {
        codigo: "2407",
        descripcion: "Existe mas de un tag sac:AdditionalProperty con el mismo ID",
        tipo:'Rechazo'
    },
    {
        codigo: "2408",
        descripcion: "El dato ingresado en PriceAmount del Valor referencial unitario por item no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2409",
        descripcion: "Existe mas de un tag cac:AlternativeConditionPrice con el mismo cbc:PriceTypeCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2410",
        descripcion: "Se ha consignado un valor invalido en el campo cbc:PriceTypeCode",
        tipo:'Rechazo'
    },
    {
        codigo: "2411",
        descripcion: "Ha consignado mas de un elemento cac:AllowanceCharge con el mismo campo cbc:ChargeIndicator",
        tipo:'Rechazo'
    },
    {
        codigo: "2412",
        descripcion: "Se ha consignado mas de un documento afectado por la nota (tag cac:BillingReference)",
        tipo:'Rechazo'
    },
    {
        codigo: "2413",
        descripcion: "Se ha consignado mas de un motivo o sustento de la nota (tag cac:DiscrepancyResponse/cbc:Description)",
        tipo:'Rechazo'
    },
    {
        codigo: "2414",
        descripcion: "No se ha consignado en la nota el tag cac:DiscrepancyResponse",
        tipo:'Rechazo'
    },
    {
        codigo: "2415",
        descripcion: "Se ha consignado en la nota mas de un tag cac:DiscrepancyResponse",
        tipo:'Rechazo'
    },
    {
        codigo: "2416",
        descripcion: "Si existe leyenda Transferencia Gratuita debe consignar Total Valor de Venta de Operaciones Gratuitas",
        tipo:'Rechazo'
    },
    {
        codigo: "2417",
        descripcion: "Debe consignar Valor Referencial unitario por item en operaciones no onerosas",
        tipo:'Rechazo'
    },
    {
        codigo: "2418",
        descripcion: "Si consigna Valor Referencial unitario por item en operaciones no onerosas,la operacion debe ser no onerosa.",
        tipo:'Rechazo'
    },
    {
        codigo: "2419",
        descripcion: "El dato ingresado en AllowanceTotalAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2420",
        descripcion: "Ya transcurrieron mas de 25 dias calendarios para concluir con su proceso de homologacion",
        tipo:'Rechazo'
    },
    {
        codigo: "2421",
        descripcion: "Debe indicar  toda la informacion de  sustento de translado de bienes.",
        tipo:'Rechazo'
    },
    {
        codigo: "2422",
        descripcion: "El valor unitario debe ser menor al precio unitario.",
        tipo:'Rechazo'
    },
    {
        codigo: "2423",
        descripcion: "Si ha consignado monto ISC a nivel de item, debe consignar un monto a nivel de total.",
        tipo:'Rechazo'
    },
    {
        codigo: "2424",
        descripcion: "RC Debe consignar solo un elemento sac:BillingPayment a nivel de item con cbc:InstructionID igual a 05.",
        tipo:'Rechazo'
    },
    {
        codigo: "2425",
        descripcion: "Si la  operacion es gratuita PriceTypeCode =02 y cbc:PriceAmount> 0 el codigo de afectacion de igv debe ser  no onerosa es  decir diferente de 10,20,30.",
        tipo:'Rechazo'
    },
    {
        codigo: "2426",
        descripcion: "Documentos relacionados duplicados en el comprobante.",
        tipo:'Rechazo'
    },
    {
        codigo: "2427",
        descripcion: "Solo debe de existir un tag AdditionalInformation.",
        tipo:'Rechazo'
    },
    {
        codigo: "2428",
        descripcion: "Comprobante no cumple con grupo de facturas con detracciones.",
        tipo:'Rechazo'
    },
    {
        codigo: "2429",
        descripcion: "Comprobante no cumple con grupo de facturas con comercio exterior.",
        tipo:'Rechazo'
    },
    {
        codigo: "2430",
        descripcion: "Comprobante no cumple con grupo de facturas con tag de factura guia.",
        tipo:'Rechazo'
    },
    {
        codigo: "2431",
        descripcion: "Comprobante no cumple con grupo de facturas con tags no tributarios.",
        tipo:'Rechazo'
    },
    {
        codigo: "2432",
        descripcion: "Comprobante no cumple con grupo de boletas con tags no tributarios.",
        tipo:'Rechazo'
    },
    {
        codigo: "2433",
        descripcion: "Comprobante no cumple con grupo de facturas con tag venta itinerante.",
        tipo:'Rechazo'
    },
    {
        codigo: "2434",
        descripcion: "Comprobante no cumple con grupo de boletas con tag venta itinerante.",
        tipo:'Rechazo'
    },
    {
        codigo: "2435",
        descripcion: "Comprobante no cumple con grupo de boletas con ISC.",
        tipo:'Rechazo'
    },
    {
        codigo: "2436",
        descripcion: "Comprobante no cumple con el grupo de boletas de venta con percepcion: El monto de percepcion no existe o es cero.",
        tipo:'Rechazo'
    },
    {
        codigo: "2437",
        descripcion: "Comprobante no cumple con el grupo de boletas de venta con percepcion: Todos los items deben tener código de Afectación al IGV igual a 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2438",
        descripcion: "Comprobante no cumple con grupo de facturas con tag venta anticipada I.",
        tipo:'Rechazo'
    },
    {
        codigo: "2439",
        descripcion: "Comprobante no cumple con grupo de facturas con tag venta anticipada II.",
        tipo:'Rechazo'
    },
    {
        codigo: "2500",
        descripcion: "Ingresar descripción y valor venta por ítem para documento de anticipos.",
        tipo:'Rechazo'
    },
    {
        codigo: "2501",
        descripcion: "Valor venta debe ser mayor a cero.",
        tipo:'Rechazo'
    },
    {
        codigo: "2502",
        descripcion: "El importe total para tipo de operación Venta interna-Anticipos debe ser mayor a cero.",
        tipo:'Rechazo'
    },
    {
        codigo: "2503",
        descripcion: "PaidAmount: monto anticipado por documento debe ser mayor a cero.",
        tipo:'Rechazo'
    },
    {
        codigo: "2504",
        descripcion: "Falta referencia de la factura relacionada con anticipo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2505",
      descipcion: "codigo de documento de referencia debe ser 02 o 03.",
      tipo:'Rechazo'
    },
    {
        codigo: "2506",
        descripcion: "cac:PrepaidPayment/cbc:ID: Factura o boleta no existe o comunicada de Baja.",
        tipo:'Rechazo'
    },
    {
        codigo: "2507",
        descripcion: "Factura relacionada con anticipo no corresponde como factura de anticipo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2508",
        descripcion: "Ingresar documentos por anticipos.",
        tipo:'Rechazo'
    },
    {
        codigo: "2509",
        descripcion: "Total de anticipos diferente a los montos anticipados por documento.",
        tipo:'Rechazo'
    },
    {
        codigo: "2510",
        descripcion: "Nro nombre del documento no tiene el formato correcto.",
        tipo:'Rechazo'
    },
    {
        codigo: "2511",
        descripcion: "El tipo de documento no es aceptado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2512",
        descripcion: "No existe información de serie o número.",
        tipo:'Rechazo'
    },
    {
        codigo: "2513",
        descripcion: "Dato no cumple con formato de acuerdo al tipo de documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2514",
        descripcion: "No existe información de receptor de documento.",
        tipo:'Rechazo'
    },
    {
        codigo: "2515",
        descripcion: "Dato ingresado no cumple con catalogo 6.",
        tipo:'Rechazo'
    },
    {
        codigo: "2516",
        descripcion: "Debe indicar tipo de documento.",
        tipo:'Rechazo'
    },
    {
        codigo: "2517",
        descripcion: "Dato no cumple con formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2518",
        descripcion: "Calculo IGV no es correcto.",
        tipo:'Rechazo'
    },
    {
        codigo: "2519",
        descripcion: "El importe total no coincide con la sumatoria de los valores de venta mas los tributos mas los cargos menos los descuentos que no afectan la base imponible",
        tipo:'Rechazo'
    },
    {
        codigo: "2520",
        descripcion: "El tipo documento del emisor que realiza el anticipo debe ser 6 del catalogo de tipo de documento.",
        tipo:'Rechazo'
    },
    {
        codigo: "2521",
        descripcion: "El dato ingresado debe indicar SERIE-CORRELATIVO del documento que se realizo el anticipo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2522",
        descripcion: "No existe información del documento del anticipo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2523",
        descripcion: "GrossWeightMeasure – El dato ingresado no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2524",
        descripcion: "Debe indicar el documento afectado por la nota",
        tipo:'Rechazo'
    },
    {
        codigo: "2525",
        descripcion: "El dato ingresado en Quantity no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2526",
        descripcion: "El dato ingresado en Percent no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2527",
        descripcion: "PrepaidAmount: Monto total anticipado debe ser mayor a cero.",
        tipo:'Rechazo'
    },
    {
        codigo: "2528",
        descripcion: "cac:OriginatorDocumentReference/ cbc:ID/@SchemaID – El tipo documento debe ser 6 del catalogo de tipo de documento.",
        tipo:'Rechazo'
    },
    {
        codigo: "2529",
        descripcion: "RUC que emitio documento de anticipo, no existe.",
        tipo:'Rechazo'
    },
    {
        codigo: "2530",
        descripcion: "RUC que solicita la emision de la factura, no existe.",
        tipo:'Rechazo'
    },
    {
        codigo: "2531",
        descripcion: "Codigo del Local Anexo del emisor no existe.",
        tipo:'Rechazo'
    },
    {
        codigo: "2532",
        descripcion: "No existe información de modalidad de transporte.",
        tipo:'Rechazo'
    },
    {
        codigo: "2533",
        descripcion: "Si ha consignado Transporte Privado, debe consignar Licencia de conducir, Placa, N constancia de inscripcion y marca del vehiculo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2534",
        descripcion: "Si ha consignado Transporte Público, debe consignar Datos del transportista.",
        tipo:'Rechazo'
    },
    {
        codigo: "2535",
        descripcion: "La nota de crédito por otros conceptos tributarios debe tener Otros Documentos Relacionados.",
        tipo:'Rechazo'
    },
    {
        codigo: "2536",
        descripcion: "Serie y numero no se encuentra registrado como baja por cambio de destinatario.",
        tipo:'Rechazo'
    },
    {
        codigo: "2537",
        descripcion: "cac:OrderReference/cac:DocumentReference/ cbc:DocumentTypeCode - El tipo de documento de serie y número dado de baja es incorrecta.",
        tipo:'Rechazo'
    },
    {
        codigo: "2538",
        descripcion: "El contribuyente no se encuentra autorizado como emisor electronico de Guía o de factura o de boletaFactura GEM.",
        tipo:'Rechazo'
    },
    {
        codigo: "2539",
        descripcion: "El contribuyente no esta activo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2540",
        descripcion: "El contribuyente no esta habido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2541",
        descripcion: "El XML no contiene el tag o no existe informacion del tipo de documento identidad del remitente.",
        tipo:'Rechazo'
    },
    {
        codigo: "2542",
        descripcion: "El valor ingresado como tipo de documento identidad del remitente es incorrecta.",
        tipo:'Rechazo'
    },
    {
        codigo: "2543",
        descripcion: "El XML no contiene el tag o no existe informacion de la dirección completa y detallada en domicilio fiscal.",
        tipo:'Rechazo'
    },
    {
        codigo: "2544",
        descripcion: "El XML no contiene el tag o no existe información de la provincia en domicilio fiscal.",
        tipo:'Rechazo'
    },
    {
        codigo: "2545",
        descripcion: "El XML no contiene el tag o no existe información del departamento en domicilio fiscal.",
        tipo:'Rechazo'
    },
    {
        codigo: "2546",
        descripcion: "El XML no contiene el tag o no existe información del distrito en domicilio fiscal.",
        tipo:'Rechazo'
    },
    {
        codigo: "2547",
        descripcion: "El XML no contiene el tag o no existe información del país en domicilio fiscal.",
        tipo:'Rechazo'
    },
    {
        codigo: "2548",
        descripcion: "El valor del país inválido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2549",
        descripcion: "El XML no contiene el tag o no existe informacion del tipo de documento identidad del destinatario.",
        tipo:'Rechazo'
    },
    {
        codigo: "2550",
        descripcion: " El dato ingresado de tipo de documento identidad del destinatario no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2551",
        descripcion: "El XML no contiene el tag o no existe informacion de CustomerAssignedAccountID del proveedor de servicios.",
        tipo:'Rechazo'
    },
    {
        codigo: "2552",
        descripcion: "El XML no contiene el tag o no existe informacion del tipo de documento identidad del proveedor.",
        tipo:'Rechazo'
    },
    {
        codigo: "2553",
        descripcion: " El dato ingresado no es valido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2554",
        descripcion: "Para el motivo de traslado ingresado el Destinatario debe ser igual al remitente.",
        tipo:'Rechazo'
    },
    {
        codigo: "2555",
        descripcion: "Destinatario no debe ser igual al remitente.",
        tipo:'Rechazo'
    },
    {
        codigo: "2556",
        descripcion: "cbc:TransportModeCode -  dato ingresado no es valido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2557",
        descripcion: "La fecha del StartDate no debe ser menor al Today.",
        tipo:'Rechazo'
    },
    {
        codigo: "2558",
        descripcion: "El XML no contiene el tag o no existe informacion en Numero de Ruc del transportista.",
        tipo:'Rechazo'
    },
    {
        codigo: "2559",
        descripcion: "El dato ingresado no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2560",
        descripcion: "Transportista  no debe ser igual al remitente o destinatario.",
        tipo:'Rechazo'
    },
    {
        codigo: "2561",
        descripcion: "El XML no contiene el tag o no existe informacion del tipo de documento identidad del transportista.",
        tipo:'Rechazo'
    },
    {
        codigo: "2562",
        descripcion: "El dato ingresado no es valido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2563",
        descripcion: "El XML no contiene el tag o no existe informacion de Apellido, Nombre o razon social del transportista.",
        tipo:'Rechazo'
    },
    {
        codigo: "2564",
        descripcion: "Razon social transportista - El dato ingresado no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2565",
        descripcion: "El XML no contiene el tag o no existe informacion del tipo de unidad de transporte.",
        tipo:'Rechazo'
    },
    {
        codigo: "2566",
        descripcion: "El XML no contiene el tag o no existe informacion del Numero de placa del vehículo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2567",
        descripcion: "Numero de placa del vehículo - El dato ingresado no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2568",
        descripcion: "El XML no contiene el tag o no existe informacion en el Numero de documento de identidad del conductor.",
        tipo:'Rechazo'
    },
    {
        codigo: "2569",
        descripcion: "Documento identidad del conductor - El dato ingresado no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2570",
        descripcion: "El XML no contiene el tag o no existe informacion del tipo de documento identidad del conductor.",
        tipo:'Rechazo'
    },
    {
        codigo: "2571",
        descripcion: "cac:DriverPerson/ID@schemeID - El valor ingresado de tipo de documento identidad de conductor es incorrecto.",
        tipo:'Rechazo'
    },
    {
        codigo: "2572",
        descripcion: "El XML no contiene el tag o no existe informacion del Numero de licencia del conductor.",
        tipo:'Rechazo'
    },
    {
        codigo: "2573",
        descripcion: "Numero de licencia del conductor - El dato ingresado no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2574",
        descripcion: "El XML no contiene el tag o no existe informacion de direccion detallada de punto de llegada.",
        tipo:'Rechazo'
    },
    {
        codigo: "2575",
        descripcion: "El XML no contiene el tag o no existe informacion de CityName.",
        tipo:'Rechazo'
    },
    {
        codigo: "2576",
        descripcion: "El XML no contiene el tag o no existe informacion de District.",
        tipo:'Rechazo'
    },
    {
        codigo: "2577",
        descripcion: "El XML no contiene el tag o no existe informacion de direccion detallada de punto de partida.",
        tipo:'Rechazo'
    },
    {
        codigo: "2578",
        descripcion: "El XML no contiene el tag o no existe informacion de CityName.",
        tipo:'Rechazo'
    },
    {
        codigo: "2579",
        descripcion: "El XML no contiene el tag o no existe informacion de District.",
        tipo:'Rechazo'
    },
    {
        codigo: "2580",
        descripcion: "El XML No contiene el tag o no existe información de la cantidad del item.",
        tipo:'Rechazo'
    },
    {
        codigo: "2581",
        descripcion: "No puede dar de baja 'Recibos de servicios publicos' por SEE-Desde los sistemas del contribuyente",
        tipo:'Rechazo'
    },
    {
        codigo: "2582",
        descripcion: "Solo se debe incluir el tag de Comprobante de referencia cuando se trata de una nota de credito o debito",
        tipo:'Rechazo'
    },
    {
        codigo: "2583",
        descripcion: "Debe consignar tipo de documento que modifica",
        tipo:'Rechazo'
    },
    {
        codigo: "2600",
        descripcion: "El comprobante fue enviado fuera del plazo permitido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2601",
        descripcion: "Señor contribuyente a la fecha no se encuentra registrado ó habilitado con la condición de Agente de percepción.",
        tipo:'Rechazo'
    },
    {
        codigo: "2602",
        descripcion: "El régimen percepción enviado no corresponde con su condición de Agente de percepción.",
        tipo:'Rechazo'
    },
    {
        codigo: "2603",
        descripcion: "La tasa de percepción enviada no corresponde con el régimen de percepción.",
        tipo:'Rechazo'
    },
    {
        codigo: "2604",
        descripcion: "El Cliente no puede ser el mismo que el Emisor del comprobante de percepción.",
        tipo:'Rechazo'
    },
    {
        codigo: "2605",
        descripcion: "Número de RUC no existe.",
        tipo:'Rechazo'
    },
    {
        codigo: "2606",
        descripcion: "Documento de identidad del Cliente no existe.",
        tipo:'Rechazo'
    },
    {
        codigo: "2607",
        descripcion: "La moneda del importe de cobro debe ser la misma que la del documento relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2608",
        descripcion: "Los montos de pago, percibidos y montos cobrados consignados para el documento relacionado no son correctos.",
        tipo:'Rechazo'
    },
    {
        codigo: "2609",
        descripcion: "El comprobante electrónico enviado no se encuentra registrado en la SUNAT.",
        tipo:'Rechazo'
    },
    {
        codigo: "2610",
        descripcion: "La fecha de emisión, Importe total del comprobante y la moneda del comprobante electrónico enviado no son los registrados en los Sistemas de SUNAT.",
        tipo:'Rechazo'
    },
    {
        codigo: "2611",
        descripcion: "El comprobante electrónico no ha sido emitido al cliente.",
        tipo:'Rechazo'
    },
    {
        codigo: "2612",
        descripcion: "La fecha de cobro debe estar entre el primer día calendario del mes al cual corresponde la fecha de emisión del comprobante de percepción o desde la fecha de emisión del comprobante relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2613",
        descripcion: "El Nro. de documento con número de cobro ya se encuentra en la Relación de Documentos Relacionados agregados.",
        tipo:'Rechazo'
    },
    {
        codigo: "2614",
        descripcion: "El Nro. de documento con el número de cobro ya se encuentra registrado como pago realizado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2615",
        descripcion: "Importe total percibido debe ser igual a la suma de los importes percibidos por cada documento relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2616",
        descripcion: "Importe total cobrado debe ser igual a la suma de los importe totales cobrados por cada documento relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2617",
        descripcion: "Señor contribuyente a la fecha no se encuentra registrado ó habilitado con la condición de Agente de retención.",
        tipo:'Rechazo'
    },
    {
        codigo: "2618",
        descripcion: "El régimen retención enviado no corresponde con su condición de Agente de retención.",
        tipo:'Rechazo'
    },
    {
        codigo: "2619",
        descripcion: "La tasa de retención enviada no corresponde con el régimen de retención.",
        tipo:'Rechazo'
    },
    {
        codigo: "2620",
        descripcion: "El Proveedor no puede ser el mismo que el Emisor del comprobante de retención.",
        tipo:'Rechazo'
    },
    {
        codigo: "2621",
        descripcion: "Número de RUC del Proveedor no existe.",
        tipo:'Rechazo'
    },
    {
        codigo: "2622",
        descripcion: "La moneda del importe de pago debe ser la misma que la del documento relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2623",
        descripcion: "Los montos de pago, retenidos y montos pagados consignados para el documento relacionado no son correctos.",
        tipo:'Rechazo'
    },
    {
        codigo: "2624",
        descripcion: "El comprobante electrónico no ha sido emitido por el proveedor.",
        tipo:'Rechazo'
    },
    {
        codigo: "2625",
        descripcion: "La fecha de pago debe estar entre el primer día calendario del mes al cual corresponde la fecha de emisión del comprobante de retención o desde la fecha de emisión del comprobante relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2626",
        descripcion: "El Nro. de documento con el número de pago ya se encuentra en la Relación de Documentos Relacionados agregados.",
        tipo:'Rechazo'
    },
    {
        codigo: "2627",
        descripcion: "El Nro. de documento con el número de pago ya se encuentra registrado como pago realizado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2628",
        descripcion: "Importe total retenido debe ser igual a la suma de los importes retenidos por cada documento relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2629",
        descripcion: "Importe total pagado debe ser igual a la suma de los importes pagados por cada documento relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2630",
        descripcion: "La serie o numero del documento(01) modificado por la Nota de Credito no cumple con el formato establecido para tipo codigo Nota Credito 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2631",
        descripcion: "La serie o numero del documento(12) modificado por la Nota de Credito no cumple con el formato establecido para tipo codigo Nota Credito 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2632",
        descripcion: "La serie o numero del documento(56) modificado por la Nota de Credito no cumple con el formato establecido para tipo codigo Nota Credito 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2633",
        descripcion: "La serie o numero del documento(03) modificado por la Nota de Credito no cumple con el formato establecido para tipo codigo Nota Credito 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2634",
        descripcion: "ReferenceID - El dato ingresado debe indicar serie correcta del documento al que se relaciona la Nota tipo 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2635",
        descripcion: "Debe existir DocumentTypeCode de Otros documentos relacionados con valor 99 para un tipo codigo Nota Credito 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2636",
        descripcion: "No existe datos del ID de los documentos relacionados con valor 99 para un tipo codigo Nota Credito 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2637",
        descripcion: "No existe datos del DocumentType de los documentos relacionados con valor 99 para un tipo codigo Nota Credito 10.",
        tipo:'Rechazo'
    },
    {
        codigo: "2640",
        descripcion: "Operacion gratuita, solo debe consignar un monto referencial",
        tipo:'Rechazo'
    },
    {
        codigo: "2641",
        descripcion: "Operacion gratuita,  debe consignar Total valor venta - operaciones gratuitas  mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2642",
        descripcion: "Operaciones de exportacion, deben consignar Tipo Afectacion igual a 40",
        tipo:'Rechazo'
    },
    {
        codigo: "2643",
        descripcion: "Factura de operacion sujeta IVAP debe consignar Monto de impuestos por item",
        tipo:'Rechazo'
    },
    {
        codigo: "2644",
        descripcion: "Comprobante operacion sujeta IVAP solo debe tener ítems con código de afectación del IGV igual a 17",
        tipo:'Rechazo'
    },
    {
        codigo: "2645",
        descripcion: "Factura de operacion sujeta a IVAP debe consignar items con codigo de tributo 1000",
        tipo:'Rechazo'
    },
    {
        codigo: "2646",
        descripcion: "Factura de operacion sujeta a IVAP debe consignar  items con nombre  de tributo IVAP",
        tipo:'Rechazo'
    },
    {
        codigo: "2647",
      descipcion: "codigo tributo  UN/ECE debe ser VAT",
      tipo:'Rechazo'
    },
    {
        codigo: "2648",
        descripcion: "Factura de operacion sujeta al IVAP, solo puede consignar informacion para operacion gravadas",
        tipo:'Rechazo'
    },
    {
        codigo: "2649",
        descripcion: "Operación sujeta al IVAP, debe consignar monto en total operaciones gravadas",
        tipo:'Rechazo'
    },
    {
        codigo: "2650",
        descripcion: "Factura de operacion sujeta al IVAP , no debe consignar valor para ISC o debe ser 0",
        tipo:'Rechazo'
    },
    {
        codigo: "2651",
        descripcion: "Factura de operacion sujeta al IVAP , no debe consignar valor para IGV o debe ser 0",
        tipo:'Rechazo'
    },
    {
        codigo: "2652",
        descripcion: "Factura de operacion sujeta al IVAP , debe registrar mensaje 2007",
        tipo:'Rechazo'
    },
    {
        codigo: "2653",
        descripcion: "Servicios prestados No domiciliados. Total IGV debe se mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2654",
      descipcion: "Servicios prestados No domiciliados. codigo tributo a consignar debe ser 1000",
      tipo:'Rechazo'
    },
    {
        codigo: "2655",
        descripcion: "Servicios prestados No domiciliados. El código de afectación debe ser 40",
        tipo:'Rechazo'
    },
    {
        codigo: "2656",
      descipcion: "Servicios prestados No domiciliados. codigo tributo  UN/ECE debe ser VAT",
      tipo:'Rechazo'
    },
    {
        codigo: "2657",
        descripcion: "El Nro. de documento ya fué utilizado en la emision de CPE.",
        tipo:'Rechazo'
    },
    {
        codigo: "2658",
        descripcion: "El Nro. de documento no se ha informado o no se encuentra en estado Revertido",
        tipo:'Rechazo'
    },
    {
        codigo: "2659",
        descripcion: "La fecha de cobro de cada documento relacionado deben ser del mismo Periodo (mm/aaaa), asimismo estas fechas podrán ser menores o iguales a la fecha de emisión del comprobante de percepción",
        tipo:'Rechazo'
    },
    {
        codigo: "2660",
        descripcion: "Los datos del CPE revertido no corresponden a los registrados en la SUNAT",
        tipo:'Rechazo'
    },
    {
        codigo: "2661",
        descripcion: "La fecha de cobro de cada documento relacionado deben ser del mismo Periodo (mm/aaaa), asimismo estas fechas podrán ser menores o iguales a la fecha de emisión del comprobante de retencion",
        tipo:'Rechazo'
    },
    {
        codigo: "2662",
        descripcion: "El Nro. de documento ya fué utilizado en la emision de CRE.",
        tipo:'Rechazo'
    },
    {
        codigo: "2663",
        descripcion: "El documento indicado no existe no puede ser modificado",
        tipo:'Rechazo'
    },
    {
        codigo: "2664",
        descripcion: "El calculo de la base imponible de percepción y el monto de la percepción no coincide con el monto total informado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2665",
        descripcion: "El contribuyente no se encuentra autorizado a emitir Tickets",
        tipo:'Rechazo'
    },
    {
        codigo: "2666",
        descripcion: "Las percepciones son solo válidas para boletas de venta al contado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2667",
        descripcion: "Importe total percibido debe ser igual a la suma de los importes percibidos por cada documento relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2668",
        descripcion: "Importe total cobrado debe ser igual a la suma de los importes cobrados por cada documento relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2669",
        descripcion: "El dato ingresado en TotalInvoiceAmount debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2670",
        descripcion: "La razón social no corresponde al ruc informado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2671",
        descripcion: "La fecha de generación de la comunicación/resumen debe ser mayor o igual a la fecha de generación/emisión de los documentos",
        tipo:'Rechazo'
    },
    {
        codigo: "2672",
        descripcion: "La fecha de generación del documento revertido debe ser menor o igual a la fecha actual.",
        tipo:'Rechazo'
    },
    {
        codigo: "2673",
        descripcion: "El dato ingresado no cumple con el formato RR-fecha-correlativo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2674",
        descripcion: "El dato ingresado  no cumple con el formato de DocumentSerialID, para DocumentTypeCode con valor 20.",
        tipo:'Rechazo'
    },
    {
        codigo: "2675",
        descripcion: "El dato ingresado  no cumple con el formato de DocumentSerialID, para DocumentTypeCode con valor 40.",
        tipo:'Rechazo'
    },
    {
        codigo: "2676",
        descripcion: "El XML no contiene el tag o no existe información del número de RUC del emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "2677",
        descripcion: "El valor ingresado como número de RUC del emisor es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2678",
        descripcion: "El XML no contiene el atributo o no existe información del tipo de documento del emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "2679",
        descripcion: "El XML no contiene el tag o no existe información del número de documento de identidad del cliente",
        tipo:'Rechazo'
    },
    {
        codigo: "2680",
        descripcion: "El valor ingresado como documento de identidad del cliente es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2681",
        descripcion: "El XML no contiene el atributo o no existe información del tipo de documento del cliente",
        tipo:'Rechazo'
    },
    {
        codigo: "2682",
        descripcion: "El valor ingresado como tipo de documento del cliente es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2683",
        descripcion: "El XML no contiene el tag o no existe información del Importe total Percibido",
        tipo:'Rechazo'
    },
    {
        codigo: "2684",
        descripcion: "El XML no contiene el tag o no existe información de la moneda del Importe total Percibido",
        tipo:'Rechazo'
    },
    {
        codigo: "2685",
        descripcion: "El valor de la moneda del Importe total Percibido debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2686",
        descripcion: "El XML no contiene el tag o no existe información del Importe total Cobrado",
        tipo:'Rechazo'
    },
    {
        codigo: "2687",
        descripcion: "El dato ingresado en SUNATTotalCashed debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2689",
        descripcion: "El XML no contiene el tag o no existe información de la moneda del Importe total Cobrado",
        tipo:'Rechazo'
    },
    {
        codigo: "2690",
        descripcion: "El valor de la moneda del Importe total Cobrado debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2691",
        descripcion: "El XML no contiene el tag o no existe información del tipo de documento relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2692",
        descripcion: "El tipo de documento relacionado no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2693",
        descripcion: "El XML no contiene el tag o no existe información del número de documento relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2694",
        descripcion: "El número de documento relacionado no está permitido o no es valido",
        tipo:'Rechazo'
    },
    {
        codigo: "2695",
        descripcion: "El XML no contiene el tag o no existe información del Importe total documento Relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2696",
        descripcion: "El dato ingresado en el importe total documento relacionado debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2697",
        descripcion: "El XML no contiene el tag o no existe información del número de cobro",
        tipo:'Rechazo'
    },
    {
        codigo: "2698",
        descripcion: "El dato ingresado en el número de cobro no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2699",
        descripcion: "El XML no contiene el tag o no existe información del Importe del cobro",
        tipo:'Rechazo'
    },
    {
        codigo: "2700",
        descripcion: "El dato ingresado en el Importe del cobro debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2701",
        descripcion: "El XML no contiene el tag o no existe información de la moneda del documento Relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2702",
        descripcion: "El XML no contiene el tag o no existe información de la fecha de cobro del documento Relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2703",
        descripcion: "La fecha de cobro del documento relacionado no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2704",
        descripcion: "El XML no contiene el tag o no existe información del Importe percibido",
        tipo:'Rechazo'
    },
    {
        codigo: "2705",
        descripcion: "El dato ingresado en el Importe percibido debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2706",
        descripcion: "El XML no contiene el tag o no existe información de la moneda de importe percibido",
        tipo:'Rechazo'
    },
    {
        codigo: "2707",
        descripcion: "El valor de la moneda de importe percibido debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2708",
        descripcion: "El XML no contiene el tag o no existe información de la Fecha de Percepción",
        tipo:'Rechazo'
    },
    {
        codigo: "2709",
        descripcion: "La fecha de percepción no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2710",
        descripcion: "El XML no contiene el tag o no existe información del Monto total a cobrar",
        tipo:'Rechazo'
    },
    {
        codigo: "2711",
        descripcion: "El dato ingresado en el Monto total a cobrar debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2712",
        descripcion: "El XML no contiene el tag o no existe información de la moneda del Monto total a cobrar",
        tipo:'Rechazo'
    },
    {
        codigo: "2713",
        descripcion: "El valor de la moneda del Monto total a cobrar debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2714",
        descripcion: "El valor de la moneda de referencia para el tipo de cambio no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2715",
        descripcion: "El valor de la moneda objetivo para la Tasa de Cambio debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2716",
        descripcion: "El dato ingresado en el tipo de cambio debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2717",
        descripcion: "La fecha de cambio no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2718",
        descripcion: "El valor de la moneda del documento Relacionado no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2719",
        descripcion: "El XML no contiene el tag o no existe información de la moneda de referencia para el tipo de cambio",
        tipo:'Rechazo'
    },
    {
        codigo: "2720",
        descripcion: "El XML no contiene el tag o no existe información de la moneda objetivo para la Tasa de Cambio",
        tipo:'Rechazo'
    },
    {
        codigo: "2721",
        descripcion: "El XML no contiene el tag o no existe información del tipo de cambio",
        tipo:'Rechazo'
    },
    {
        codigo: "2722",
        descripcion: "El XML no contiene el tag o no existe información de la fecha de cambio",
        tipo:'Rechazo'
    },
    {
        codigo: "2723",
        descripcion: "El XML no contiene el tag o no existe información del número de documento de identidad del proveedor",
        tipo:'Rechazo'
    },
    {
        codigo: "2724",
        descripcion: "El valor ingresado como documento de identidad del proveedor es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2725",
        descripcion: "El XML no contiene el tag o no existe información del Importe total Retenido",
        tipo:'Rechazo'
    },
    {
        codigo: "2726",
        descripcion: "El XML no contiene el tag o no existe información de la moneda del Importe total Retenido",
        tipo:'Rechazo'
    },
    {
        codigo: "2727",
        descripcion: "El XML no contiene el tag o no existe información de la moneda del Importe total Retenido",
        tipo:'Rechazo'
    },
    {
        codigo: "2728",
        descripcion: "El valor de la moneda del Importe total Retenido debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2729",
        descripcion: "El XML no contiene el tag o no existe información del Importe total Pagado",
        tipo:'Rechazo'
    },
    {
        codigo: "2730",
        descripcion: "El dato ingresado en SUNATTotalPaid debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2731",
        descripcion: "El XML no contiene el tag o no existe información de la moneda del Importe total Pagado",
        tipo:'Rechazo'
    },
    {
        codigo: "2732",
        descripcion: "El valor de la moneda del Importe total Pagado debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2733",
        descripcion: "El XML no contiene el tag o no existe información del número de pago",
        tipo:'Rechazo'
    },
    {
        codigo: "2734",
        descripcion: "El dato ingresado en el número de pago no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2735",
        descripcion: "El XML no contiene el tag o no existe información del Importe del pago",
        tipo:'Rechazo'
    },
    {
        codigo: "2736",
        descripcion: "El dato ingresado en el Importe del pago debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2737",
        descripcion: "El XML no contiene el tag o no existe información de la fecha de pago del documento Relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2738",
        descripcion: "La fecha de pago del documento relacionado no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2739",
        descripcion: "El XML no contiene el tag o no existe información del Importe retenido",
        tipo:'Rechazo'
    },
    {
        codigo: "2740",
        descripcion: "El dato ingresado en el Importe retenido debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2741",
        descripcion: "El XML no contiene el tag o no existe información de la moneda de importe retenido",
        tipo:'Rechazo'
    },
    {
        codigo: "2742",
        descripcion: "El valor de la moneda de importe retenido debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2743",
        descripcion: "El XML no contiene el tag o no existe información de la Fecha de Retención",
        tipo:'Rechazo'
    },
    {
        codigo: "2744",
        descripcion: "La fecha de retención no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2745",
        descripcion: "El XML no contiene el tag o no existe información del Importe total a pagar (neto)",
        tipo:'Rechazo'
    },
    {
        codigo: "2746",
        descripcion: "El dato ingresado en el Importe total a pagar (neto) debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2747",
        descripcion: "El XML no contiene el tag o no existe información de la Moneda del monto neto pagado",
        tipo:'Rechazo'
    },
    {
        codigo: "2748",
        descripcion: "El valor de la Moneda del monto neto pagado debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2749",
        descripcion: "La moneda de referencia para el tipo de cambio debe ser la misma que la del documento relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2750",
        descripcion: "El comprobante que desea revertir no existe.",
        tipo:'Rechazo'
    },
    {
        codigo: "2751",
        descripcion: "El comprobante fue informado previamente en una reversión.",
        tipo:'Rechazo'
    },
    {
        codigo: "2752",
        descripcion: "El número de ítem no puede estar duplicado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2753",
        descripcion: "No debe existir mas de una referencia en guía dada de baja.",
        tipo:'Rechazo'
    },
    {
        codigo: "2754",
        descripcion: "El tipo de documento de la guia dada de baja es incorrecto (tipo documento = 09).",
        tipo:'Rechazo'
    },
    {
        codigo: "2755",
        descripcion: "El tipo de documento relacionado es incorrecto (ver catalogo nro 21).",
        tipo:'Rechazo'
    },
    {
        codigo: "2756",
        descripcion: "El numero de documento relacionado no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2757",
        descripcion: "El XML no contiene el tag o no existe información del número de documento de identidad del destinatario.",
        tipo:'Rechazo'
    },
    {
        codigo: "2758",
        descripcion: "El valor ingresado como numero de documento de identidad del destinatario no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2759",
        descripcion: "El XML no contiene el atributo o no existe información del tipo de documento del destinatario.",
        tipo:'Rechazo'
    },
    {
        codigo: "2760",
        descripcion: "El valor ingresado como tipo de documento del destinatario es incorrecto.",
        tipo:'Rechazo'
    },
    {
        codigo: "2761",
        descripcion: "El XML no contiene el atributo o no existe información del nombre o razon social del destinatario.",
        tipo:'Rechazo'
    },
    {
        codigo: "2762",
        descripcion: "El valor ingresado como tipo de documento del nombre o razon social del destinatario es incorrecto.",
        tipo:'Rechazo'
    },
    {
        codigo: "2763",
        descripcion: "El XML no contiene el tag o no existe información del número de documento de identidad del tercero relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2764",
        descripcion: "El valor ingresado como numero de documento de identidad del tercero relacionado no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2765",
        descripcion: "El XML no contiene el atributo o no existe información del tipo de documento del tercero relacionado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2766",
        descripcion: "El valor ingresado como tipo de documento del tercero relacionado es incorrecto.",
        tipo:'Rechazo'
    },
    {
        codigo: "2767",
        descripcion: "Para exportación, el XML no contiene el tag o no existe informacion del numero de DAM.",
        tipo:'Rechazo'
    },
    {
        codigo: "2768",
        descripcion: "Para importación, el XML no contiene el tag o no existe informacion del numero de manifiesto de carga o numero de DAM.",
        tipo:'Rechazo'
    },
    {
        codigo: "2769",
        descripcion: "El valor ingresado como numero de DAM no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2770",
        descripcion: "El valor ingresado como numero de manifiesto de carga no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2771",
        descripcion: "El XML no contiene el atributo o no existe informacion en numero de bultos o pallets obligatorio para importación.",
        tipo:'Rechazo'
    },
    {
        codigo: "2772",
        descripcion: "El valor ingresado como numero de bultos o pallets no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2773",
        descripcion: "El valor ingresado como modalidad de transporte no es correcto.",
        tipo:'Rechazo'
    },
    {
        codigo: "2774",
        descripcion: "El XML contiene datos de vehiculo o datos de conductores para una operación de transporte publico completo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2775",
        descripcion: "El XML no contiene el atributo o no existe informacion del codigo de ubigeo.",
        tipo:'Rechazo'
    },
    {
        codigo: "2776",
        descripcion: "El valor ingresado como codigo de ubigeo no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2777",
        descripcion: "El XML no contiene el atributo o no existe informacion de direccion completa y detallada.",
        tipo:'Rechazo'
    },
    {
        codigo: "2778",
        descripcion: "El valor ingresado como direccion completa y detallada no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2779",
        descripcion: "El XML no contiene el atributo o no existe informacion de cantida de items",
        tipo:'Rechazo'
    },
    {
        codigo: "2780",
        descripcion: "El valor ingresado en cantidad de items no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2781",
        descripcion: "El XML no contiene el atributo o no existe informacion de descripcion del items",
        tipo:'Rechazo'
    },
    {
        codigo: "2782",
        descripcion: "El valor ingresado en descripcion del items no cumple con el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "2783",
        descripcion: "El valor ingresado en codigo del item no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2784",
        descripcion: "Debe consignar codigo de regimen de percepcion (sac:AdditionalMonetaryTotal/cbc:ID@schemeID).",
        tipo:'Rechazo'
    },
    {
        codigo: "2785",
        descripcion: "sac:ReferenceAmount es obligatorio y mayor a cero cuando sac:AdditionalMonetaryTotal/cbc:ID es 2001",
        tipo:'Rechazo'
    },
    {
        codigo: "2786",
        descripcion: "El dato ingresado en sac:ReferenceAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2787",
        descripcion: "Debe consignar la moneda para la Base imponible percepcion.",
        tipo:'Rechazo'
    },
    {
        codigo: "2788",
        descripcion: "El dato ingresado en moneda debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2789",
        descripcion: "cbc:PayableAmount es obligatorio y mayor a cero cuando sac:AdditionalMonetaryTotal/cbc:ID es 2001",
        tipo:'Rechazo'
    },
    {
        codigo: "2790",
        descripcion: "El dato ingresado en cbc:PayableAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2791",
        descripcion: "Debe consignar la moneda para el Monto de la percepcion (cbc:PayableAmount/@currencyID)",
        tipo:'Rechazo'
    },
    {
        codigo: "2792",
        descripcion: "El dato ingresado en moneda del monto de cargo/descuento para percepcion debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2793",
        descripcion: "sac:TotalAmount es obligatorio y mayor a cero cuando sac:AdditionalMonetaryTotal/cbc:ID es 2001",
        tipo:'Rechazo'
    },
    {
        codigo: "2794",
        descripcion: "El dato ingresado en sac:TotalAmount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2795",
        descripcion: "Debe consignar la moneda para el Monto Total incluido la percepcion (sac:TotalAmount/@currencyID)",
        tipo:'Rechazo'
    },
    {
        codigo: "2796",
        descripcion: "El dato ingresado en sac:TotalAmount/@currencyID debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2797",
        descripcion: "El Monto de percepcion no puede ser mayor al importe total del comprobante.",
        tipo:'Rechazo'
    },
    {
        codigo: "2798",
        descripcion: "El Monto de percepcion no tiene el valor correcto según el tipo de percepcion.",
        tipo:'Rechazo'
    },
    {
        codigo: "2799",
        descripcion: "sac:TotalAmount no tiene el valor correcto cuando sac:AdditionalMonetaryTotal/cbc:ID es 2001",
        tipo:'Rechazo'
    },
    {
        codigo: "2800",
        descripcion: "El dato ingresado en el tipo de documento de identidad del receptor no esta permitido.",
        tipo:'Rechazo'
    },
    {
        codigo: "2801",
        descripcion: "El DNI ingresado no cumple con el estandar.",
        tipo:'Rechazo'
    },
    {
        codigo: "2802",
        descripcion: "El dato ingresado como numero de documento de identidad del receptor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2803",
        descripcion: "ID - No cumple con el formato UUID",
        tipo:'Rechazo'
    },
    {
        codigo: "2804",
        descripcion: "La fecha de recepcion del comprobante por OSE, no debe de ser mayor a la fecha de recepcion de SUNAT",
        tipo:'Rechazo'
    },
    {
        codigo: "2805",
        descripcion: "El XML no contiene el tag IssueTime",
        tipo:'Rechazo'
    },
    {
        codigo: "2806",
        descripcion: "IssueTime - El dato ingresado  no cumple con el patrón hh:mm:ss.sssss",
        tipo:'Rechazo'
    },
    {
        codigo: "2807",
        descripcion: "El XML no contiene el tag ResponseDate",
        tipo:'Rechazo'
    },
    {
        codigo: "2808",
        descripcion: "ResponseDate - El dato ingresado  no cumple con el patrón YYYY-MM-DD",
        tipo:'Rechazo'
    },
    {
        codigo: "2809",
        descripcion: "La fecha de recepcion del comprobante por OSE, no debe de ser mayor a la fecha de comprobacion del OSE",
        tipo:'Rechazo'
    },
    {
        codigo: "2810",
        descripcion: "La fecha de comprobacion del comprobante en OSE no puede ser mayor a la fecha de recepcion en SUNAT",
        tipo:'Rechazo'
    },
    {
        codigo: "2811",
        descripcion: "El XML no contiene el tag ResponseTime",
        tipo:'Rechazo'
    },
    {
        codigo: "2812",
        descripcion: "ResponseTime - El dato ingresado  no cumple con el patrón hh:mm:ss.sssss",
        tipo:'Rechazo'
    },
    {
        codigo: "2813",
        descripcion: "El XML no contiene el tag o no existe información del Número de documento de identificación del que envía el CPE (emisor o PSE)",
        tipo:'Rechazo'
    },
    {
        codigo: "2814",
        descripcion: "El valor ingresado como Número de documento de identificación del que envía el CPE (emisor o PSE) es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2816",
        descripcion: "El XML no contiene el atributo schemeID o no existe información del Tipo de documento de identidad del que envía el CPE (emisor o PSE)",
        tipo:'Rechazo'
    },
    {
        codigo: "2817",
        descripcion: "El valor ingresado como Tipo de documento de identidad del que envía el CPE (emisor o PSE) es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2818",
        descripcion: "El XML no contiene el atributo schemeAgencyName o no existe información del Tipo de documento de identidad del que envía el CPE (emisor o PSE)",
        tipo:'Rechazo'
    },
    {
        codigo: "2819",
        descripcion: "El valor ingresado en el atributo schemeAgencyName del Tipo de documento de identidad del que envía el CPE (emisor o PSE) es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2820",
        descripcion: "El XML no contiene el atributo schemeURI o no existe información del Tipo de documento de identidad del que envía el CPE (emisor o PSE)",
        tipo:'Rechazo'
    },
    {
        codigo: "2821",
        descripcion: "El valor ingresado en el atributo schemeURI del Tipo de documento de identidad del que envía el CPE (emisor o PSE) es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2822",
        descripcion: "El XML no contiene el tag o no existe información del Número de documento de identificación del OSE",
        tipo:'Rechazo'
    },
    {
        codigo: "2823",
        descripcion: "El valor ingresado como Número de documento de identificación del OSE es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2824",
        descripcion: "El certificado digital con el que se firma el CDR OSE no corresponde con el RUC del OSE informado",
        tipo:'Rechazo'
    },
    {
        codigo: "2825",
        descripcion: "El Número de documento de identificación del OSE informado no esta registrado en el padron.",
        tipo:'Rechazo'
    },
    {
        codigo: "2826",
        descripcion: "El XML no contiene el atributo schemeID o no existe información del Tipo de documento de identidad del OSE",
        tipo:'Rechazo'
    },
    {
        codigo: "2827",
        descripcion: "El valor ingresado como Tipo de documento de identidad del OSE es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2828",
        descripcion: "El XML no contiene el atributo schemeAgencyName o no existe información del Tipo de documento de identidad del OSE",
        tipo:'Rechazo'
    },
    {
        codigo: "2829",
        descripcion: "El valor ingresado en el atributo schemeAgencyName del Tipo de documento de identidad del OSE es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2830",
        descripcion: "El XML no contiene el atributo schemeURI o no existe información del Tipo de documento de identidad del OSE",
        tipo:'Rechazo'
    },
    {
        codigo: "2831",
        descripcion: "El valor ingresado en el atributo schemeURI del Tipo de documento de identidad del OSE es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2832",
      descipcion: "El XML no contiene el tag o no existe información del codigo de Respuesta",
      tipo:'Rechazo'
    },
    {
        codigo: "2833",
      descipcion: "El valor ingresado como codigo de Respuesta es incorrecto",
      tipo:'Rechazo'
    },
    {
        codigo: "2834",
      descipcion: "El XML no contiene el atributo listAgencyName o no existe información del codigo de Respuesta",
      tipo:'Rechazo'
    },
    {
        codigo: "2835",
      descipcion: "El valor ingresado en el atributo listAgencyName del codigo de Respuesta es incorrecto",
      tipo:'Rechazo'
    },
    {
        codigo: "2836",
        descripcion: "El XML no contiene el tag o no existe información de la Descripción de la Respuesta",
        tipo:'Rechazo'
    },
    {
        codigo: "2837",
        descripcion: "El valor ingresado como Descripción de la Respuesta es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2838",
      descipcion: "El valor ingresado como codigo de observación es incorrecto",
      tipo:'Rechazo'
    },
    {
        codigo: "2839",
      descipcion: "El XML no contiene el atributo listURI o no existe información del codigo de observación",
      tipo:'Rechazo'
    },
    {
        codigo: "2840",
      descipcion: "El valor ingresado en el atributo listURI del codigo de observación es incorrecto",
      tipo:'Rechazo'
    },
    {
        codigo: "2841",
        descripcion: "El XML no contiene el tag o no existe información de la Descripción de la observación",
        tipo:'Rechazo'
    },
    {
        codigo: "2842",
        descripcion: "El valor ingresado como Descripción de la observación es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2843",
        descripcion: "Se ha encontrado mas de una Descripción de la observación, tag cac:Response/cac:Status/cbc:StatusReason",
        tipo:'Rechazo'
    },
    {
        codigo: "2844",
        descripcion: "No se encontro el tag cbc:StatusReasonCode cuando ingresó la Descripción de la observación",
        tipo:'Rechazo'
    },
    {
        codigo: "2845",
        descripcion: "El XML contiene mas de un elemento cac:DocumentReference",
        tipo:'Rechazo'
    },
    {
        codigo: "2846",
        descripcion: "El XML no contiene informacion en el tag cac:DocumentReference/cbc:ID",
        tipo:'Rechazo'
    },
    {
        codigo: "2848",
        descripcion: "El valor ingresado como Serie y número del comprobante no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2849",
        descripcion: "El XML no contiene el tag o no existe información de la Fecha de emisión del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2851",
        descripcion: "El valor ingresado como Fecha de emisión del comprobante no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2852",
        descripcion: "El XML no contiene el tag o no existe información de la Hora de emisión del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2853",
        descripcion: "El valor ingresado como Hora de emisión del comprobante no cumple con el patrón hh:mm:ss.sssss",
        tipo:'Rechazo'
    },
    {
        codigo: "2854",
        descripcion: "El valor ingresado como Hora de emisión del comprobante no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2855",
        descripcion: "El XML no contiene el tag o no existe información del Tipo de comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2856",
        descripcion: "El valor ingresado como Tipo de comprobante es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2857",
        descripcion: "El valor ingresado como Tipo de comprobante no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2858",
        descripcion: "El XML no contiene el tag o no existe información del Hash del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2859",
        descripcion: "El valor ingresado como Hash del comprobante es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2860",
        descripcion: "El valor ingresado como Hash del comprobante no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2861",
        descripcion: "El XML no contiene el tag o no existe información del Número de documento de identificación del emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "2862",
        descripcion: "El valor ingresado como Número de documento de identificación del emisor es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2863",
        descripcion: "El valor ingresado como Número de documento de identificación del emisor no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2864",
        descripcion: "El XML no contiene el atributo o no existe información del Tipo de documento de identidad del emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "2865",
        descripcion: "El valor ingresado como Tipo de documento de identidad del emisor es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2866",
        descripcion: "El valor ingresado como Tipo de documento de identidad del emisor no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2867",
        descripcion: "El XML no contiene el tag o no existe información del Número de documento de identificación del receptor",
        tipo:'Rechazo'
    },
    {
        codigo: "2868",
        descripcion: "El valor ingresado como Número de documento de identificación del receptor es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2869",
        descripcion: "El valor ingresado como Número de documento de identificación del receptor no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2870",
        descripcion: "El XML no contiene el atributo o no existe información del Tipo de documento de identidad del receptor",
        tipo:'Rechazo'
    },
    {
        codigo: "2871",
        descripcion: "El valor ingresado como Tipo de documento de identidad del receptor es incorrecto",
        tipo:'Rechazo'
    },
    {
        codigo: "2872",
        descripcion: "El valor ingresado como Tipo de documento de identidad del receptor no corresponde con el del comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "2873",
        descripcion: "El PSE informado no se encuentra vinculado con el  emisor del comprobante en la fecha de comprobación",
        tipo:'Rechazo'
    },
    {
        codigo: "2874",
        descripcion: "El Número de documento de identificación del OSE informado no se encuentra vinculado al emisor del comprobante en la fecha de comprobación",
        tipo:'Rechazo'
    },
    {
        codigo: "2875",
        descripcion: "ID - El dato ingresado no cumple con el formato R#-fecha-correlativo",
        tipo:'Rechazo'
    },
    {
        codigo: "2876",
        descripcion: "La fecha de recepción del comprobante por OSE debe ser mayor a la fecha de emisión del comprobante enviado",
        tipo:'Rechazo'
    },
    {
        codigo: "2880",
        descripcion: "Es obligatorio ingresar el peso bruto total de la guía",
        tipo:'Rechazo'
    },
    {
        codigo: "2881",
        descripcion: "Es obligatorio indicar la unidad de medida del Peso Total de la guía",
        tipo:'Rechazo'
    },
    {
        codigo: "2883",
        descripcion: "Es obligatorio indicar la unidad de medida del ítem",
        tipo:'Rechazo'
    },
    {
        codigo: "2891",
        descripcion: "La tasa de percepción no existe en el catálogo",
        tipo:'Rechazo'
    },
    {
        codigo: "2892",
        descripcion: "El valor del tag no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2893",
        descripcion: "El valor no cumple con el formato establecido o es menor o igual a cero (0)",
        tipo:'Rechazo'
    },
    {
        codigo: "2894",
        descripcion: "El valor del tag no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2895",
        descripcion: "El valor no cumple con el formato establecido o es menor o igual a cero (0)",
        tipo:'Rechazo'
    },
    {
        codigo: "2896",
        descripcion: "El código ingresado como estado del ítem no existe en el catálogo",
        tipo:'Rechazo'
    },
    {
        codigo: "2897",
        descripcion: "El valor no cumple con el formato establecido o es menor o igual a cero (0)",
        tipo:'Rechazo'
    },
    {
        codigo: "2900",
        descripcion: "El Número de comprobante de fin de rango debe ser igual o mayor al de inicio",
        tipo:'Rechazo'
    },
    {
        codigo: "2901",
        descripcion: "El nombre comercial del emisor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2902",
        descripcion: "La urbanización del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2903",
        descripcion: "La provincia del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2904",
        descripcion: "El departamento del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2905",
        descripcion: "El distrito del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2906",
        descripcion: "El nombre comercial del proveedor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2907",
        descripcion: "La urbanización del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2908",
        descripcion: "La provincia del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2909",
        descripcion: "El departamento del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2910",
        descripcion: "El distrito del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2911",
        descripcion: "El nombre comercial del cliente no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2912",
        descripcion: "La urbanización del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2913",
        descripcion: "La provincia del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2914",
        descripcion: "El departamento del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2915",
        descripcion: "El distrito del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2916",
        descripcion: "La dirección completa y detallada del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2917",
        descripcion: "Debe corresponder a algún valor válido establecido en el catálogo 13",
        tipo:'Rechazo'
    },
    {
        codigo: "2918",
        descripcion: "La dirección completa y detallada del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2919",
        descripcion: "La dirección completa y detallada del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2920",
        descripcion: "Dato no cumple con formato de acuerdo al tipo de documento",
        tipo:'Rechazo'
    },
    {
        codigo: "2921",
        descripcion: "Es obligatorio informar el detalle el tipo de servicio público",
        tipo:'Rechazo'
    },
    {
        codigo: "2922",
        descripcion: "El valor del Tag no se encuentra en el catálogo",
        tipo:'Rechazo'
    },
    {
        codigo: "2923",
        descripcion: "Es obligatorio informar el código de servicios de telecomunicaciones para el tipo servicio público informado",
        tipo:'Rechazo'
    },
    {
        codigo: "2924",
        descripcion: "Sólo enviar información para el tipos de servicios públicos 5",
        tipo:'Rechazo'
    },
    {
        codigo: "2925",
        descripcion: "El valor del Tag no se encuentra en el catálogo",
        tipo:'Rechazo'
    },
    {
        codigo: "2926",
        descripcion: "Es obligatorio informar el número del suministro para el tipo servicio público informado",
        tipo:'Rechazo'
    },
    {
        codigo: "2927",
        descripcion: "Comprobante de Servicio Publico no se encuenta registrado en sunat",
        tipo:'Rechazo'
    },
    {
        codigo: "2928",
        descripcion: "El valor del Tag no cumple con el tipo y longitud esperada",
        tipo:'Rechazo'
    },
    {
        codigo: "2929",
        descripcion: "Debe remitir información del número de teléfono para el código de servicios de telecomunicaciones informado",
        tipo:'Rechazo'
    },
    {
        codigo: "2930",
        descripcion: "El tipo de documento modificado por la Nota de debito debe ser Servicio Publico electronico",
        tipo:'Rechazo'
    },
    {
        codigo: "2931",
        descripcion: "El valor del Tag no cumple con el tipo y longitud esperada",
        tipo:'Rechazo'
    },
    {
        codigo: "2932",
        descripcion: "Es obligatorio informar el código de tarifa contratada para el tipo servicio público informado",
        tipo:'Rechazo'
    },
    {
        codigo: "2933",
        descripcion: "Sólo enviar información para el tipos de servicios públicos 1 o 2",
        tipo:'Rechazo'
    },
    {
        codigo: "2934",
        descripcion: "El valor del Tag no se encuentra en el catálogo",
        tipo:'Rechazo'
    },
    {
        codigo: "2935",
        descripcion: "Es obligatorio informar la unidad de medida",
        tipo:'Rechazo'
    },
    {
        codigo: "2936",
        descripcion: "El dato ingresado como unidad de medida no corresponde al valor esperado",
        tipo:'Rechazo'
    },
    {
        codigo: "2937",
        descripcion: "Es obligatorio informar el detalle de la potencia contratada",
        tipo:'Rechazo'
    },
    {
        codigo: "2938",
        descripcion: "Sólo enviar información para el tipo de servicios público 1",
        tipo:'Rechazo'
    },
    {
        codigo: "2939",
        descripcion: "El valor del Tag no cumple con el tipo y longitud esperada",
        tipo:'Rechazo'
    },
    {
        codigo: "2940",
        descripcion: "Es obligatorio informar el tipo de medidor ",
        tipo:'Rechazo'
    },
    {
        codigo: "2941",
        descripcion: "Sólo enviar información para el tipo de servicios público 1",
        tipo:'Rechazo'
    },
    {
        codigo: "2942",
        descripcion: "El valor del Tag no se encuentra en el catálogo",
        tipo:'Rechazo'
    },
    {
        codigo: "2943",
        descripcion: "Es obligatorio informar el número del medidor",
        tipo:'Rechazo'
    },
    {
        codigo: "2944",
        descripcion: "Sólo enviar información para el tipos de servicios públicos 1 o 2",
        tipo:'Rechazo'
    },
    {
        codigo: "2945",
        descripcion: "El valor del Tag no cumple con el tipo y longitud esperada",
        tipo:'Rechazo'
    },
    {
        codigo: "2946",
        descripcion: "Debe informar el consumo del periodo",
        tipo:'Rechazo'
    },
    {
        codigo: "2947",
        descripcion: "No existe el detalle del número del medidor",
        tipo:'Rechazo'
    },
    {
        codigo: "2948",
        descripcion: "Sólo enviar información para el tipos de servicios públicos 1 o 2",
        tipo:'Rechazo'
    },
    {
        codigo: "2949",
        descripcion: "El impuesto ICBPER no se encuentra vigente",
        tipo:'Rechazo'
    },
    {
        codigo: "2950",
        descripcion: "El comprobante ha sido presentado fuera de plazo",
        tipo:'Rechazo'
    },
    {
        codigo: "2951",
        descripcion: "Sólo enviar información para el tipos de servicios públicos 1 o 2",
        tipo:'Rechazo'
    },
    {
        codigo: "2952",
        descripcion: "El valor del Tag no cumple con el tipo y longitud esperada",
        tipo:'Rechazo'
    },
    {
        codigo: "2953",
        descripcion: "Es obligatorio indicar la unidad de medida del ítem",
        tipo:'Rechazo'
    },
    {
        codigo: "2954",
        descripcion: "El valor ingresado como codigo de motivo de cargo/descuento por linea no es valido (catalogo 53)",
        tipo:'Rechazo'
    },
    {
        codigo: "2955",
        descripcion: "El formato ingresado en el tag cac:InvoiceLine/cac:Allowancecharge/cbc:Amount no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "2956",
        descripcion: "El Monto total de impuestos es obligatorio",
        tipo:'Rechazo'
    },
    {
        codigo: "2957",
        descripcion: "El comprobante no puede ser dado de baja por exceder el plazo desde su fecha de emision",
        tipo:'Rechazo'
    },
    {
        codigo: "2958",
        descripcion: "El comprobante no puede ser dado de baja por exceder el plazo desde su fecha de recepcion",
        tipo:'Rechazo'
    },
    {
        codigo: "2959",
        descripcion: "El valor del atributo del tag cac:TaxTotal/cac:TaxSubtotal/ cac:TaxCategory/cbc:ID/ no corresponde al esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2960",
        descripcion: "El valor del tag no corresponde al esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2961",
        descripcion: "El valor del tag codigo de tributo internacional no corresponde al esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2962",
        descripcion: "El valor del atributo del tag cac:TaxTotal/cac:TaxSubtotal/ cac:TaxCategory/cac:TaxScheme/cbc:ID no corresponde al esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2963",
        descripcion: "El valor del atributo del tag cac:TaxTotal/cac:TaxSubtotal/ cac:TaxCategory/cbc:ID/ no corresponde al esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2964",
        descripcion: "El valor del tag nombre del tributo no corresponde al esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2965",
        descripcion: "La sumatoria de otros tributos no corresponde al total",
        tipo:'Rechazo'
    },
    {
        codigo: "2966",
        descripcion: "Sólo se puede indicar el códigos 55 del catálogo 53",
        tipo:'Rechazo'
    },
    {
        codigo: "2967",
        descripcion: "Los importes de otros cargos a nivel de línea no corresponden a la suma total.",
        tipo:'Rechazo'
    },
    {
        codigo: "2968",
        descripcion: "El dato ingresado en cac:AllowanceCharge/cbc:Amount no cumple con el formato establecido. ",
        tipo:'Rechazo'
    },
    {
        codigo: "2969",
        descripcion: "Los importes de otros cargos a nivel de línea no corresponden a la suma total.",
        tipo:'Rechazo'
    },
    {
        codigo: "2970",
        descripcion: "El dato ingresado en sac:SUNATTotalPaidBeforeRounding debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2971",
        descripcion: "Si existe tag sac:SUNATTotalPaidBeforeRounding debe existir tag cbc:PayableRoundingAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2972",
        descripcion: "Importe total pagado antes de redondeo debe ser igual a la suma de los importes pagados por cada documento relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2973",
        descripcion: "El valor de la moneda del Importe total pagado antes de redondeo debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2974",
        descripcion: "El dato ingresado en cbc:PayableRoundingAmount debe ser numérico valido",
        tipo:'Rechazo'
    },
    {
        codigo: "2975",
        descripcion: "Si existe tag cbc:PayableRoundingAmount debe existir tag sac:SUNATTotalPaidBeforeRounding",
        tipo:'Rechazo'
    },
    {
        codigo: "2976",
        descripcion: "El valor para el ajuste por redondeo no es válido",
        tipo:'Rechazo'
    },
    {
        codigo: "2977",
        descripcion: "El valor de la moneda del Ajuste por redondeo debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2978",
        descripcion: "Importe total pagado debe ser igual a la suma del Importe total pagado antes de redondeo mas el Ajuste por redondeo",
        tipo:'Rechazo'
    },
    {
        codigo: "2979",
        descripcion: "El dato ingresado en sac:SUNATTotalCashedBeforeRounding debe ser numérico mayor a cero",
        tipo:'Rechazo'
    },
    {
        codigo: "2980",
        descripcion: "Si existe tag sac:SUNATTotalCashedBeforeRounding debe existir tag cbc:PayableRoundingAmount",
        tipo:'Rechazo'
    },
    {
        codigo: "2981",
        descripcion: "Importe total cobrado antes de redondeo debe ser igual a la suma de los importes cobrados por cada documento relacionado",
        tipo:'Rechazo'
    },
    {
        codigo: "2982",
        descripcion: "El valor de la moneda del Importe total cobrado antes de redondeo debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "2983",
        descripcion: "Si existe tag cbc:PayableRoundingAmount debe existir tag sac:SUNATTotalCashedBeforeRounding",
        tipo:'Rechazo'
    },
    {
        codigo: "2984",
        descripcion: "Importe total cobrado debe ser igual a la suma del Importe total cobrado antes de redondeo mas el Ajuste por redondeo",
        tipo:'Rechazo'
    },
    {
        codigo: "2985",
        descripcion: "Solo se acepta comprobantes con fecha de emisión hasta el 28/02/2014 si la tasa del comprobante de retencion 6%",
        tipo:'Rechazo'
    },
    {
        codigo: "2986",
        descripcion: "Solo se acepta informacion de percepcion para nuevas boletas.",
        tipo:'Rechazo'
    },
    {
        codigo: "2987",
        descripcion: "El comprobante ya fue informado y se encuentra anulado o rechazado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2988",
        descripcion: "El comprobante (fisico) a la que hace referencia la nota, no se encuentra autorizado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2989",
        descripcion: "El comprobante (electronico) a la que hace referencia la nota, no se encuentra informado.",
        tipo:'Rechazo'
    },
    {
        codigo: "2990",
        descripcion: "El comprobante (electronico) a la que hace referencia la nota, se encuentra anulado o rechazada.",
        tipo:'Rechazo'
    },
    {
        codigo: "2991",
        descripcion: "El tipo de documento modificado por la Nota de credito debe ser comprobante de servicio publico",
        tipo:'Rechazo'
    },
    {
        codigo: "2992",
        descripcion: "El XML no contiene el tag de la tasa del tributo de la línea",
        tipo:'Rechazo'
    },
    {
        codigo: "2993",
        descripcion: "El factor de afectación de IGV por linea debe ser diferente a 0.00.",
        tipo:'Rechazo'
    },
    {
        codigo: "2994",
        descripcion: "La categoría de impuesto de la línea no corresponde al valor esperado (catalogo 5)",
        tipo:'Rechazo'
    },
    {
        codigo: "2995",
        descripcion: "El XML no contiene el tag o no existe información del código internacional de tributo de la línea",
        tipo:'Rechazo'
    },
    {
        codigo: "2996",
        descripcion: "El XML no contiene el tag o no existe información del nombre de tributo de la línea",
        tipo:'Rechazo'
    },
    {
        codigo: "2997",
        descripcion: "El XML no contiene el tag o no existe información del código de tributo de la línea",
        tipo:'Rechazo'
    },
    {
        codigo: "2998",
        descripcion: "El código de tributo de la línea no corresponde al valor esperado",
        tipo:'Rechazo'
    },
    {
        codigo: "2999",
        descripcion: "El dato ingresado en el total valor de venta globales no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3000",
        descripcion: "El monto total del impuestos sobre el valor de venta de operaciones gratuitas/inafectas/exoneradas debe ser igual a 0.00 ",
        tipo:'Rechazo'
    },
    {
        codigo: "3001",
      descipcion: "El codigo producto de SUNAT no puede ser vacio si es de Exportacion",
      tipo:'Rechazo'
    },
    {
        codigo: "3002",
      descipcion: "El codigo producto de SUNAT  no es válido",
      tipo:'Rechazo'
    },
    {
        codigo: "3003",
        descripcion: "El XML no contiene el tag o no existe información de total valor de venta globales",
        tipo:'Rechazo'
    },
    {
        codigo: "3004",
        descripcion: "El XML no contiene el tag o no existe información de la categoría de impuesto globales",
        tipo:'Rechazo'
    },
    {
        codigo: "3005",
        descripcion: "El XML no contiene el tag o no existe información del código de tributo en operaciones inafectas/exoneradas",
        tipo:'Rechazo'
    },
    {
        codigo: "3006",
        descripcion: "El dato ingresado en descripcion de leyenda no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "3007",
        descripcion: "El dato ingresado como codigo de tributo global no corresponde al valor esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "3008",
        descripcion: "La sumatoria del total valor de venta - Otros tributos de pago de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3009",
        descripcion: "La sumatoria del total del importe del tributo Otros tributos de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3010",
        descripcion: "El XML no contiene el tag o no existe información de total valor de venta en operaciones gravadas",
        tipo:'Rechazo'
    },
    {
        codigo: "3011",
        descripcion: "El dato ingresado en el total valor de venta en operaciones gravadas  no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3012",
        descripcion: "El dato ingresado en el importe del tributo en operaciones gravadas  no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3013",
        descripcion: "El XML no contiene el tag o no existe información de la categoría de impuesto en operaciones gravadas",
        tipo:'Rechazo'
    },
    {
        codigo: "3014",
        descripcion: "El codigo de leyenda no debe repetirse en el comprobante.",
        tipo:'Rechazo'
    },
    {
        codigo: "3015",
        descripcion: "El XML no contiene el tag o no existe información del código de tributo en operaciones gravadas",
        tipo:'Rechazo'
    },
    {
        codigo: "3016",
        descripcion: "El dato ingresado en base monto por cargo/descuento globales no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3017",
        descripcion: "El XML no contiene el tag o no existe información del nombre de tributo en operaciones gravadas",
        tipo:'Rechazo'
    },
    {
        codigo: "3018",
        descripcion: "El XML no contiene el tag o no existe información del código internacional del tributo en operaciones gravadas",
        tipo:'Rechazo'
    },
    {
        codigo: "3019",
        descripcion: "El dato ingresado en total precio de venta no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3020",
        descripcion: "El dato ingresado en el monto total de impuestos no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3021",
        descripcion: "El dato ingresado en el monto total de impuestos por línea no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3022",
        descripcion: "El importe total de impuestos por línea no coincide con la sumatoria de los impuestos por línea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3023",
        descripcion: "El tipo de documento no se encuentra en el catálogo ",
        tipo:'Rechazo'
    },
    {
        codigo: "3024",
        descripcion: "El tag cac:TaxTotal no debe repetirse a nivel de totales",
        tipo:'Rechazo'
    },
    {
        codigo: "3025",
        descripcion: "El dato ingresado en factor de cargo o descuento global no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "3026",
        descripcion: "El tag cac:TaxTotal no debe repetirse a nivel de Item",
        tipo:'Rechazo'
    },
    {
        codigo: "3027",
        descripcion: "El valor del atributo no se encuentra en el catálogo",
        tipo:'Rechazo'
    },
    {
        codigo: "3028",
        descripcion: "El dato ingresado en código de SW de facturación no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "3029",
        descripcion: "El XML no contiene el tag o no existe información del tipo de documento de identidad del emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "3030",
        descripcion: "El XML no contiene el tag o no existe información del código de local anexo del emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "3031",
        descripcion: "El dato ingresado en TaxableAmount de la linea no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3032",
        descripcion: "El XML no contiene el tag o no existe información de la categoría de impuesto de la línea",
        tipo:'Rechazo'
    },
    {
        codigo: "3033",
        descripcion: "El codigo de bien o servicio sujeto a detracción no existe en el listado.",
        tipo:'Rechazo'
    },
    {
        codigo: "3034",
        descripcion: "El xml no contiene el tag o no existe información en el nro de cuenta de detracción",
        tipo:'Rechazo'
    },
    {
        codigo: "3035",
        descripcion: "El xml no contiene el tag o no existe información en el monto de detraccion",
        tipo:'Rechazo'
    },
    {
        codigo: "3036",
        descripcion: "El XML no contiene el tag o no existe información del nombre del tributo",
        tipo:'Rechazo'
    },
    {
        codigo: "3037",
        descripcion: "El dato ingresado en monto de detraccion no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3038",
        descripcion: "La sumatoria de los IGV (operaciones gravadas) de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3039",
        descripcion: "La sumatoria del total valor de venta - operaciones gravadas de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3040",
        descripcion: "La sumatoria del total valor de venta - Exportaciones de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3041",
        descripcion: "La sumatoria del total valor de venta - operaciones inafectas de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3042",
        descripcion: "La sumatoria del total valor de venta - operaciones exoneradas de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3043",
        descripcion: "El XML no contiene el tag o no existe información de total valor de venta ISC e IVAP",
        tipo:'Rechazo'
    },
    {
        codigo: "3044",
        descripcion: "El dato ingresado en el total valor de venta ISC e IVAP no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3045",
        descripcion: "La sumatoria del total valor de venta - ISC de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3046",
        descripcion: "La sumatoria del total valor de venta - IVAP de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3047",
        descripcion: "El dato ingresado en el importe del tributo para ISC e IVAP no cumple con el formato establecido",
        tipo:'Rechazo'
    },
    {
        codigo: "3048",
        descripcion: "La sumatoria del total del importe del tributo ISC de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3049",
        descripcion: "El importe del IVAP no corresponden al determinado por la información consignada.",
        tipo:'Rechazo'
    },
    {
        codigo: "3050",
        descripcion: "Afectación de IGV no corresponde al código de tributo de la linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3051",
        descripcion: "Nombre de tributo no corresponde al código de tributo de la linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3052",
        descripcion: "El factor de cargo/descuento por linea no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "3053",
        descripcion: "El Monto base de cargo/descuento por linea no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "3054",
        descripcion: "El XML no contiene el tag o no existe información de la categoría de impuesto en ISC o IVAP",
        tipo:'Rechazo'
    },
    {
        codigo: "3055",
        descripcion: "Si el código de tributo es 2000, la categoría del tributo debe ser S",
        tipo:'Rechazo'
    },
    {
        codigo: "3056",
        descripcion: "Si el código de tributo es 1016, la categoría del tributo debe ser S",
        tipo:'Rechazo'
    },
    {
        codigo: "3057",
        descripcion: "La sumatoria del total valor de venta - operaciones gratuitas de línea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3058",
        descripcion: "El XML no contiene el tag o no existe información del código de tributo para ISC o IVAP",
        tipo:'Rechazo'
    },
    {
        codigo: "3059",
        descripcion: "el XML no contiene el tag o no existe información de código de tributo.",
        tipo:'Rechazo'
    },
    {
        codigo: "3060",
        descripcion: "El valor del tag código de tributo no corresponde al esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "3061",
        descripcion: "No se permite importe mayor a cero cuando el codigo de tributo es IVAP y el comprobante esta sujeta a IVAP",
        tipo:'Rechazo'
    },
    {
        codigo: "3062",
        descripcion: "La tasa o porcentaje de detracción no corresponde al valor esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "3063",
        descripcion: "El XML no contiene el tag de matricula de embarcación en Detracciones para recursos hidrobiologicos.",
        tipo:'Rechazo'
    },
    {
        codigo: "3064",
        descripcion: "El XML no contiene tag o no existe información del valor del concepto por linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3065",
        descripcion: "El XML no contiene tag de la fecha del concepto por linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3066",
        descripcion: "El XML contiene un codigo de tributo no valido para Servicios Publicos.",
        tipo:'Rechazo'
    },
    {
        codigo: "3067",
        descripcion: "El código de tributo no debe repetirse a nivel de item",
        tipo:'Rechazo'
    },
    {
        codigo: "3068",
        descripcion: "El código de tributo no debe repetirse a nivel de totales",
        tipo:'Rechazo'
    },
    {
        codigo: "3069",
        descripcion: "El xml contiene una linea con mas de un codigo de tributo repetitivo.",
        tipo:'Rechazo'
    },
    {
        codigo: "3070",
        descripcion: "EL codigo internacional del tributo por linea no corresponde al valor esperado por su Id.",
        tipo:'Rechazo'
    },
    {
        codigo: "3071",
        descripcion: "El dato ingresado como codigo de motivo de cargo/descuento global no es valido (catalogo nro 53)",
        tipo:'Rechazo'
    },
    {
        codigo: "3072",
        descripcion: "El XML no contiene el tag o no existe informacion de codigo de motivo de cargo/descuento global.",
        tipo:'Rechazo'
    },
    {
        codigo: "3073",
        descripcion: "El XML no contiene el tag o no existe informacion de codigo de motivo de cargo/descuento por item.",
        tipo:'Rechazo'
    },
    {
        codigo: "3074",
        descripcion: "El monto del cargo para el para FISE debe ser igual mayor a 0.00 ",
        tipo:'Rechazo'
    },
    {
        codigo: "3075",
        descripcion: "La sumatoria de descuentos que afectan a BI por linea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3076",
        descripcion: "La sumatoria de descuentos que no afectan a BI por linea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3077",
        descripcion: "La sumatoria de cargos que afectan a BI por linea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3078",
        descripcion: "La sumatoria de cargos que no afectan a BI por linea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3079",
        descripcion: "La sumatoria de montos bases de los descuentos que afectan a BI por linea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3080",
        descripcion: "La sumatoria de montos bases de los descuentos que no afectan a BI por linea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3081",
        descripcion: "La sumatoria de montos bases de los cargos que afectan a BI por linea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3082",
        descripcion: "La sumatoria de montos bases de los cargos que no afectan a BI por linea no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3083",
        descripcion: "El XML no contiene el tag o no existe información del total valor de venta.",
        tipo:'Rechazo'
    },
    {
        codigo: "3084",
        descripcion: "La sumatoria de valor de venta no corresponde a los importes consignados",
        tipo:'Rechazo'
    },
    {
        codigo: "3085",
        descripcion: "El XML no contiene el tag o no existe información del total precio de venta.",
        tipo:'Rechazo'
    },
    {
        codigo: "3086",
        descripcion: "La sumatoria consignados en descuentos globales no corresponden al total.",
        tipo:'Rechazo'
    },
    {
        codigo: "3087",
        descripcion: "La sumatoria consignados en cargos globales no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3088",
        descripcion: "El valor ingresado como moneda del comprobante no es valido (catalogo nro 02).",
        tipo:'Rechazo'
    },
    {
        codigo: "3089",
        descripcion: "El XML contiene mas de un tag como elemento de numero de documento del emisor",
        tipo:'Rechazo'
    },
    {
        codigo: "3090",
        descripcion: "El XML contiene mas de un tag como elemento de numero de documento del receptor.",
        tipo:'Rechazo'
    },
    {
        codigo: "3091",
        descripcion: "Si se tipo de operación es Venta Interna - Sujeta al FISE, debe ingresar cargo para FISE",
        tipo:'Rechazo'
    },
    {
        codigo: "3092",
        descripcion: "Para cargo/descuento FISE, debe ingresar monto base y debe ser mayor a 0.00",
        tipo:'Rechazo'
    },
    {
        codigo: "3093",
        descripcion: "Si el tipo de operación es Operación Sujeta a Percepción, debe ingresar cargo para Percepción",
        tipo:'Rechazo'
    },
    {
        codigo: "3094",
        descripcion: "El comprobante más \"código de operación del ítem\" no debe repetirse",
        tipo:'Rechazo'
    },
    {
        codigo: "3095",
        descripcion: "El comprobante no debe ser emitido y editado en el mismo envío",
        tipo:'Rechazo'
    },
    {
        codigo: "3096",
        descripcion: "El comprobante no debe ser editado y anulado en el mismo envío",
        tipo:'Rechazo'
    },
    {
        codigo: "3097",
        descripcion: "El emisor a la fecha no se encuentra registrado ó habilitado en el Registro de exportadores de servicios SUNAT",
        tipo:'Rechazo'
    },
    {
        codigo: "3098",
        descripcion: "El XML no contiene el tag o no existe información del pais de uso, exploración o aprovechamiento",
        tipo:'Rechazo'
    },
    {
        codigo: "3099",
        descripcion: "El dato ingresado como pais de uso, exploracion o aprovechamiento es incorrecto.",
        tipo:'Rechazo'
    },
    {
        codigo: "3100",
        descripcion: "El dato ingresado como codigo de tributo por linea es invalido para tipo de operación.",
        tipo:'Rechazo'
    },
    {
        codigo: "3101",
        descripcion: "El factor de afectación de IGV por linea debe ser igual a 0.00 para Exoneradas, Inafectas, Exportación, Gratuitas de exoneradas o Gratuitas de inafectas.",
        tipo:'Rechazo'
    },
    {
        codigo: "3102",
        descripcion: "El dato ingresado como factor de afectacion por linea no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "3103",
        descripcion: "El producto del factor y monto base de la afectación del IGV/IVAP no corresponde al monto de afectacion de linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3104",
        descripcion: "El factor de afectación de ISC por linea debe ser diferente a 0.00.",
        tipo:'Rechazo'
    },
    {
        codigo: "3105",
        descripcion: "El XML debe contener al menos un tributo por linea de afectacion por IGV (Gravada, Exonerada, Inafecta, Exportación)",
        tipo:'Rechazo'
    },
    {
        codigo: "3106",
        descripcion: "El XML contiene mas de un tributo por linea (Gravado, Exonerado, Inafecto, Exportación)",
        tipo:'Rechazo'
    },
    {
        codigo: "3107",
        descripcion: "El dato ingresado como codigo de tributo global es invalido para tipo de operación.",
        tipo:'Rechazo'
    },
    {
        codigo: "3108",
        descripcion: "El producto del factor y monto base de la afectación del ISC no corresponde al monto de afectacion de linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3109",
        descripcion: "El producto del factor y monto base de la afectación de otros tributos no corresponde al monto de afectacion de linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3110",
        descripcion: "El monto de afectacion de IGV por linea debe ser igual a 0.00 para Exoneradas, Inafectas, Exportación, Gratuitas de exoneradas o Gratuitas de inafectas.",
        tipo:'Rechazo'
    },
    {
        codigo: "3111",
        descripcion: "El monto de afectación de IGV por linea debe ser diferente a 0.00.",
        tipo:'Rechazo'
    },
    {
        codigo: "3112",
        descripcion: "La sumatoria de los IGV de operaciones gratuitas de la línea (codigo tributo 9996) no corresponden al total",
        tipo:'Rechazo'
    },
    {
        codigo: "3113",
        descripcion: "El xml contiene información FISE que no corresponde al tipo de operación.",
        tipo:'Rechazo'
    },
    {
        codigo: "3114",
        descripcion: "El dato ingresado como indicador de cargo/descuento no corresponde al valor esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "3115",
        descripcion: "El dato ingresado como unidad de medida de cantidad de especie vendidas no corresponde al valor esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "3116",
        descripcion: "El XML no contiene el tag o no existe información del ubigeo de punto de origen en Detracciones - Servicio de transporte de carga.",
        tipo:'Rechazo'
    },
    {
        codigo: "3117",
        descripcion: "El XML no contiene el tag o no existe información de la dirección del punto de origen en Detracciones - Servicio de transporte de carga.",
        tipo:'Rechazo'
    },
    {
        codigo: "3118",
        descripcion: "El XML no contiene el tag o no existe información del ubigeo de punto de destino en Detracciones - Servicio de transporte de carga.",
        tipo:'Rechazo'
    },
    {
        codigo: "3119",
        descripcion: "El XML no contiene el tag o no existe información de la dirección del punto de destino en Detracciones - Servicio de transporte de carga.",
        tipo:'Rechazo'
    },
    {
        codigo: "3120",
        descripcion: "El XML no contiene el tag o no existe información del Detalle del viaje en Detracciones - Servicio de transporte de carga.",
        tipo:'Rechazo'
    },
    {
        codigo: "3121",
        descripcion: "El XML no contiene el tag o no existe información del tipo de valor referencial en Detracciones - Servicios de transporte de carga.",
        tipo:'Rechazo'
    },
    {
        codigo: "3122",
        descripcion: "El XML no contiene el tag o no existe información del monto del valor referencial en Detracciones - Servicios de transporte de carga.",
        tipo:'Rechazo'
    },
    {
        codigo: "3123",
        descripcion: "El dato ingresado como monto valor referencial en Detracciones - Servicios de transporte de carga no cumple con el formato establecido.",
        tipo:'Rechazo'
    },
    {
        codigo: "3124",
        descripcion: "Detracciones - Servicio de transporte de carga, debe tener un (y solo uno) Valor Referencial del Servicio de Transporte.",
        tipo:'Rechazo'
    },
    {
        codigo: "3125",
        descripcion: "Detracciones - Servicio de transporte de carga, debe tener un (y solo uno) Valor Referencial sobre la carga efectiva.",
        tipo:'Rechazo'
    },
    {
        codigo: "3126",
        descripcion: "Detracciones - Servicio de transporte de carga, debe tener un (y solo uno) Valor Referencial sobre la carga util nominal.",
        tipo:'Rechazo'
    },
    {
        codigo: "3127",
        descripcion: "El XML no contiene el tag o no existe información del Codigo de BBSS de detracción para el tipo de operación.",
        tipo:'Rechazo'
    },
    {
        codigo: "3128",
        descripcion: "El XML contiene información de codigo de bien y servicio de detracción que no corresponde al tipo de operación.",
        tipo:'Rechazo'
    },
    {
        codigo: "3129",
        descripcion: "El dato ingresado como codigo de BBSS de detracción no corresponde al valor esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "3130",
        descripcion: "El XML no contiene el tag de nombre de embarcación en Detracciones para recursos hidrobiologicos.",
        tipo:'Rechazo'
    },
    {
        codigo: "3131",
        descripcion: "El XML no contiene el tag de tipo de especie vendidas en Detracciones para recursos hidrobiologicos.",
        tipo:'Rechazo'
    },
    {
        codigo: "3132",
        descripcion: "El XML no contiene el tag de lugar de descarga en Detracciones para recursos hidrobiologicos.",
        tipo:'Rechazo'
    },
    {
        codigo: "3133",
        descripcion: "El XML no contiene el tag de cantidad de especies vendidas en Detracciones para recursos hidrobiologicos.",
        tipo:'Rechazo'
    },
    {
        codigo: "3134",
        descripcion: "El XML no contiene el tag de fecha de descarga en Detracciones para recursos hidrobiologicos.",
        tipo:'Rechazo'
    },
    {
        codigo: "3135",
        descripcion: "El XML no contiene tag de la cantidad del concepto por linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3136",
        descripcion: "El XML no contiene el tag de numero de documentos del huesped.",
        tipo:'Rechazo'
    },
    {
        codigo: "3137",
        descripcion: "El XML no contiene el tag de tipo de documentos del huesped.",
        tipo:'Rechazo'
    },
    {
        codigo: "3138",
        descripcion: "El XML no contiene el tag de codigo de pais de emision del documento de identidad",
        tipo:'Rechazo'
    },
    {
        codigo: "3139",
        descripcion: "El XML no contiene el tag de apellidos y nombres del huesped.",
        tipo:'Rechazo'
    },
    {
        codigo: "3140",
        descripcion: "El XML no contiene el tag de codigo del pais de residencia.",
        tipo:'Rechazo'
    },
    {
        codigo: "3141",
        descripcion: "El XML no contiene el tag de fecha de ingreso del pais.",
        tipo:'Rechazo'
    },
    {
        codigo: "3142",
        descripcion: "El XML no contiene el tag de fecha de ingreso al establecimiento.",
        tipo:'Rechazo'
    },
    {
        codigo: "3143",
        descripcion: "El XML no contiene el tag de fecha de salida del establecimiento.",
        tipo:'Rechazo'
    },
    {
        codigo: "3144",
        descripcion: "El XML no contiene el tag de fecha de consumo.",
        tipo:'Rechazo'
    },
    {
        codigo: "3145",
        descripcion: "El XML no contiene el tag de numero de dias de permanencia.",
        tipo:'Rechazo'
    },
    {
        codigo: "3146",
        descripcion: "El XML no contiene el tag de Proveedores Estado: Número de Expediente",
        tipo:'Rechazo'
    },
    {
        codigo: "3147",
      descipcion: "El XML no contiene el tag de Proveedores Estado: codigo de Unidad Ejecutora",
      tipo:'Rechazo'
    },
    {
        codigo: "3148",
        descripcion: "El XML no contiene el tag de Proveedores Estado: N° de Proceso de Selección",
        tipo:'Rechazo'
    },
    {
        codigo: "3149",
        descripcion: "El XML no contiene el tag de Proveedores Estado: N° de Contrato",
        tipo:'Rechazo'
    },
    {
        codigo: "3150",
        descripcion: "El XML no contiene el tag de Créditos Hipotecarios: Tipo de préstamo",
        tipo:'Rechazo'
    },
    {
        codigo: "3151",
        descripcion: "El XML no contiene el tag de Créditos Hipotecarios: Partida Registral",
        tipo:'Rechazo'
    },
    {
        codigo: "3152",
        descripcion: "El XML no contiene el tag de Créditos Hipotecarios: Número de contrato",
        tipo:'Rechazo'
    },
    {
        codigo: "3153",
        descripcion: "El XML no contiene el tag de Créditos Hipotecarios: Fecha de otorgamiento del crédito",
        tipo:'Rechazo'
    },
    {
        codigo: "3154",
      descipcion: "El XML no contiene el tag de Créditos Hipotecarios: Dirección del predio - codigo de ubigeo",
      tipo:'Rechazo'
    },
    {
        codigo: "3155",
        descripcion: "El XML no contiene el tag de Créditos Hipotecarios: Dirección del predio - Dirección completa",
        tipo:'Rechazo'
    },
    {
        codigo: "3156",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Agente de Viajes: Numero de Ruc",
        tipo:'Rechazo'
    },
    {
        codigo: "3157",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Agente de Viajes: Tipo de documento",
        tipo:'Rechazo'
    },
    {
        codigo: "3158",
        descripcion: "El dato ingresado como Agente de Viajes-Tipo de documento no corresponde al valor esperado.",
        tipo:'Rechazo'
    },
    {
        codigo: "3159",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Pasajero - Apellidos y Nombres",
        tipo:'Rechazo'
    },
    {
        codigo: "3160",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Pasajero - Tipo de documento de identidad",
        tipo:'Rechazo'
    },
    {
        codigo: "3161",
      descipcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio transporte: Ciudad o lugar de origen - codigo de ubigeo",
      tipo:'Rechazo'
    },
    {
        codigo: "3162",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio transporte: Ciudad o lugar de origen - Dirección detallada",
        tipo:'Rechazo'
    },
    {
        codigo: "3163",
      descipcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio transporte: Ciudad o lugar de destino - codigo de ubigeo",
      tipo:'Rechazo'
    },
    {
        codigo: "3164",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio transporte: Ciudad o lugar de destino - Dirección detallada",
        tipo:'Rechazo'
    },
    {
        codigo: "3165",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio transporte:Número de asiento",
        tipo:'Rechazo'
    },
    {
        codigo: "3166",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio transporte: Hora programada de inicio de viaje",
        tipo:'Rechazo'
    },
    {
        codigo: "3167",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio transporte: Fecha programada de inicio de viaje",
        tipo:'Rechazo'
    },
    {
        codigo: "3168",
      descipcion: "El XML no contiene el tag de Carta Porte Aéreo:  Lugar de origen - codigo de ubigeo",
      tipo:'Rechazo'
    },
    {
        codigo: "3169",
        descripcion: "El XML no contiene el tag de Carta Porte Aéreo:  Lugar de origen - Dirección detallada",
        tipo:'Rechazo'
    },
    {
        codigo: "3170",
      descipcion: "El XML no contiene el tag de Carta Porte Aéreo:  Lugar de destino - codigo de ubigeo",
      tipo:'Rechazo'
    },
    {
        codigo: "3171",
        descripcion: "El XML no contiene el tag de Carta Porte Aéreo:  Lugar de destino - Dirección detallada",
        tipo:'Rechazo'
    },
    {
        codigo: "3172",
        descripcion: "El XML no contiene tag de la Hora del concepto por linea.",
        tipo:'Rechazo'
    },
    {
        codigo: "3173",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio transporte: Forma de Pago",
        tipo:'Rechazo'
    },
    {
        codigo: "3174",
        descripcion: "El dato ingreso como Forma de Pago o Medio de Pago no corresponde al valor esperado (catalogo nro 59)",
        tipo:'Rechazo'
    },
    {
        codigo: "3175",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Servicio de transporte: Número de autorización de la transacción",
        tipo:'Rechazo'
    },
    {
        codigo: "3176",
        descripcion: "El XML no contiene el tag de Regalía Petrolera: Decreto Supremo de aprobación del contrato",
        tipo:'Rechazo'
    },
    {
        codigo: "3177",
        descripcion: "El XML no contiene el tag de Regalía Petrolera: Area de contrato (Lote)",
        tipo:'Rechazo'
    },
    {
        codigo: "3178",
        descripcion: "El XML no contiene el tag de Regalía Petrolera: Periodo de pago - Fecha de inicio",
        tipo:'Rechazo'
    },
    {
        codigo: "3179",
        descripcion: "El XML no contiene el tag de Regalía Petrolera: Periodo de pago - Fecha de fin",
        tipo:'Rechazo'
    },
    {
        codigo: "3180",
        descripcion: "El XML no contiene el tag de Regalía Petrolera: Fecha de Pago",
        tipo:'Rechazo'
    },
    {
        codigo: "3181",
        descripcion: "El dato ingresado como Codigo de producto SUNAT no corresponde al valor esperado para tipo de operación.",
        tipo:'Rechazo'
    },
    {
        codigo: "3182",
        descripcion: "El XML no contiene el tag de Transportre Terreste - Número de asiento",
        tipo:'Rechazo'
    },
    {
        codigo: "3183",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Información de manifiesto de pasajeros",
        tipo:'Rechazo'
    },
    {
        codigo: "3184",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Número de documento de identidad del pasajero",
        tipo:'Rechazo'
    },
    {
        codigo: "3185",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Tipo de documento de identidad del pasajero",
        tipo:'Rechazo'
    },
    {
        codigo: "3186",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Nombres y apellidos del pasajero",
        tipo:'Rechazo'
    },
    {
        codigo: "3187",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Ciudad o lugar de destino - Dirección detallada",
        tipo:'Rechazo'
    },
    {
        codigo: "3188",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Ciudad o lugar de origen - Ubigeo",
        tipo:'Rechazo'
    },
    {
        codigo: "3189",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Ciudad o lugar de origen - Dirección detallada",
        tipo:'Rechazo'
    },
    {
        codigo: "3190",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Fecha de inicio programado",
        tipo:'Rechazo'
    },
    {
        codigo: "3191",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Hora de inicio programado",
        tipo:'Rechazo'
    },
    {
        codigo: "3192",
        descripcion: "El XML no contiene el tag de Total de anticipos",
        tipo:'Rechazo'
    },
    {
        codigo: "3193",
        descripcion: "El dato ingresado Total anticipos no corresponde para el tipo de operación",
        tipo:'Rechazo'
    },
    {
        codigo: "3194",
        descripcion: "Para los ajustes de operaciones de exportación solo es permitido registrar un documento que modifica.",
        tipo:'Rechazo'
    },
    {
        codigo: "3195",
        descripcion: "El xml no contiene el tag de impuesto por linea (TaxtTotal).",
        tipo:'Rechazo'
    },
    {
        codigo: "3196",
        descripcion: "La sumatoria de impuestos globales no corresponde al monto total de impuestos.",
        tipo:'Rechazo'
    },
    {
        codigo: "3197",
        descripcion: "El XML no contiene el tag de Transporte Terrestre - Ciudad o lugar de destino - Ubigeo",
        tipo:'Rechazo'
    },
    {
        codigo: "3198",
        descripcion: "La fecha de cierre no puede ser inferior a la fecha de inicio del cómputo del ciclo de facturación",
        tipo:'Rechazo'
    },
    {
        codigo: "3199",
        descripcion: "Si utiliza el estandar GS1 debe especificar el tipo de estructura GTIN",
        tipo:'Rechazo'
    },
    {
        codigo: "3200",
        descripcion: "El tipo de estructura GS1 no tiene un valor permitido",
        tipo:'Rechazo'
    },
    {
        codigo: "3201",
        descripcion: "El código de producto GS1 no cumple el estandar",
        tipo:'Rechazo'
    },
    {
        codigo: "3202",
        descripcion: "El numero de RUC del receptor no existe.",
        tipo:'Rechazo'
    },
    {
        codigo: "3203",
        descripcion: "El tipo de nota es un dato único",
        tipo:'Rechazo'
    },
    {
        codigo: "3204",
        descripcion: "El XML no contiene el tag de BVME transporte ferroviario: Pasajero - Número de documento de identidad",
        tipo:'Rechazo'
    },
    {
        codigo: "3205",
        descripcion: "Debe consignar el tipo de operación",
        tipo:'Rechazo'
    },
    {
        codigo: "3206",
        descripcion: "El dato ingresado como tipo de operación no corresponde a un valor esperado (catálogo nro. 51)",
        tipo:'Rechazo'
    },
    {
        codigo: "3207",
        descripcion: "Comprobante físico no se encuentra autorizado como comprobante de contingencia",
        tipo:'Rechazo'
    },
    {
        codigo: "3208",
        descripcion: "La moneda del monto de la detracción debe ser PEN",
        tipo:'Rechazo'
    },
    {
        codigo: "3209",
        descripcion: "El tipo de moneda de la nota debe ser el mismo que el declarado en el documento que modifica",
        tipo:'Rechazo'
    },
    {
        codigo: "3210",
        descripcion: "Solo debe consignar sistema de calculo si el tributo es ISC",
        tipo:'Rechazo'
    },
    {
        codigo: "3211",
        descripcion: "Falta identificador del pago del Monto de anticipo para relacionarlo con el comprobante que se realizo el  anticipo",
        tipo:'Rechazo'
    },
    {
        codigo: "3212",
        descripcion: "El comprobante contiene un identificador de pago repetido en los montos anticipados",
        tipo:'Rechazo'
    },
    {
        codigo: "3213",
        descripcion: "El comprobante contiene un pago anticipado pero no se ha consignado el documento que se realizo el anticipo",
        tipo:'Rechazo'
    },
    {
        codigo: "3214",
        descripcion: "No existe información del Monto Anticipado para el comprobante que se realizo el anticipo",
        tipo:'Rechazo'
    },
    {
        codigo: "3215",
        descripcion: "El comprobante contiene un identificador de pago repetido en los comprobantes que se realizo el anticipo",
        tipo:'Rechazo'
    },
    {
        codigo: "3216",
        descripcion: "Falta identificador del pago del comprobante para relacionarlo con el monto de  anticipo",
        tipo:'Rechazo'
    },
    {
        codigo: "3217",
        descripcion: "Debe consignar Numero de RUC del emisor del comprobante de anticipo",
        tipo:'Rechazo'
    },
    {
        codigo: "3218",
        descripcion: "El comprobante que se realizo el anticipo no existe",
        tipo:'Rechazo'
    },
    {
        codigo: "3219",
        descripcion: "El comprobante que se realizo el anticipo no se encuentra autorizado",
        tipo:'Rechazo'
    },
    {
        codigo: "3220",
        descripcion: "Si consigna montos de anticipo debe informar el Total de Anticipos",
        tipo:'Rechazo'
    },
    {
        codigo: "3221",
        descripcion: "El dato ingresado como codigo de tributo global es invalido para tipo de nota",
        tipo:'Rechazo'
    },
    {
        codigo: "3222",
        descripcion: "No existe información a nivel global de un tributo informado en la línea",
        tipo:'Rechazo'
    },
    {
        codigo: "3223",
        descripcion: "La combinación de tributos no es permitida",
        tipo:'Rechazo'
    },
    {
        codigo: "3224",
        descripcion: "Si existe 'Valor referencial unitario en operac. no onerosas' con monto mayor a cero, la operacion debe ser gratuita (codigo de tributo 9996)",
        tipo:'Rechazo'
    },
    {
        codigo: "3225",
        descripcion: "La base imponible a nivel de línea difiere de la información consignada en el comprobante",
        tipo:'Rechazo'
    },
    {
        codigo: "3226",
        descripcion: "El resultado del monto del cargo o descuento global es incorrecto en base a la información consignada",
        tipo:'Rechazo'
    },
    {
        codigo: "3227",
        descripcion: "La sumatoria del Total del valor de venta más los impuestos no concuerda con la base imponible",
        tipo:'Rechazo'
    },
    {
        codigo: "3228",
        descripcion: "El Comprobante de Pago no está autorizado en los Sistemas de la SUNAT.",
        tipo:'Rechazo'
    },
    {
        codigo: "3229",
        descripcion: "El monto para el redondeo del Importe Total excede el valor permitido",
        tipo:'Rechazo'
    },
    {
        codigo: "3230",
        descripcion: "Tipo de nota debe ser 'Ajustes afectos al IVAP'",
        tipo:'Rechazo'
    },
    {
        codigo: "3231",
        descripcion: "Debe consignar solo un elemento a nivel global para Percepciones (cbc:ID igual a 2001)",
        tipo:'Rechazo'
    },
    {
        codigo: "3232",
        descripcion: "Sólo los contribuyentes que hayan emitido los siguientes documentos: Guías, factura, boleta y sus respectivas notas, hasta el 30/09/2018 están autorizados a utilizar esta versión UBL",
        tipo:'Rechazo'
    },
    {
        codigo: "3233",
        descripcion: "Para cargo Percepción, debe ingresar monto base y debe ser mayor a 0.00",
        tipo:'Rechazo'
    },
    {
        codigo: "3234",
        descripcion: "El código de precio '02' es sólo para operaciones gratuitas",
        tipo:'Rechazo'
    },
    {
        codigo: "3235",
        descripcion: "No está autorizado a enviar comprobantes bajo el formato UBL 2.0",
        tipo:'Rechazo'
    },
    {
        codigo: "3236",
        descripcion: "El valor ingresado en el campo cac:TaxSubtotal/cbc:BaseUnitMeasure no corresponde al valor esperado",
        tipo:'Rechazo'
    },
    {
        codigo: "3237",
        descripcion: "Debe consignar el campo cac:TaxSubtotal/cbc:BaseUnitMeasure a nivel de ítem",
        tipo:'Rechazo'
    },
    {
        codigo: "3238",
        descripcion: "El valor ingresado en el campo cac:TaxSubtotal/cbc:PerUnitAmount del ítem no corresponde al valor esperado",
        tipo:'Rechazo'
    },
    {
        codigo: "3240",
        descripcion: "El impuesto ICBPER no aplica para el NRUS",
        tipo:'Rechazo'
    },
    {
        codigo: "4000",
        descripcion: "El documento ya fue presentado anteriormente.",
        tipo:'Observación'
    },
    {
        codigo: "4001",
        descripcion: "El numero de RUC del receptor no existe.",
        tipo:'Observación'
    },
    {
        codigo: "4002",
        descripcion: "Para el TaxTypeCode, esta usando un valor que no existe en el catalogo.",
        tipo:'Observación'
    },
    {
        codigo: "4003",
        descripcion: "El comprobante fue registrado previamente como rechazado.",
        tipo:'Observación'
    },
    {
        codigo: "4004",
        descripcion: "El DocumentTypeCode de las guias debe existir y tener 2 posiciones",
        tipo:'Observación'
    },
    {
        codigo: "4005",
        descripcion: "El DocumentTypeCode de las guias debe ser 09 o 31",
        tipo:'Observación'
    },
    {
        codigo: "4006",
        descripcion: "El ID de las guias debe tener informacion de la SERIE-NUMERO de guia.",
        tipo:'Observación'
    },
    {
        codigo: "4007",
        descripcion: "El XML no contiene el ID de las guias.",
        tipo:'Observación'
    },
    {
        codigo: "4008",
        descripcion: "El DocumentTypeCode de Otros documentos relacionados no cumple con el estandar.",
        tipo:'Observación'
    },
    {
        codigo: "4009",
        descripcion: "El DocumentTypeCode de Otros documentos relacionados tiene valores incorrectos.",
        tipo:'Observación'
    },
    {
        codigo: "4010",
        descripcion: "El ID de los documentos relacionados no cumplen con el estandar.",
        tipo:'Observación'
    },
    {
        codigo: "4011",
        descripcion: "El XML no contiene el tag ID de documentos relacionados.",
        tipo:'Observación'
    },
    {
        codigo: "4012",
        descripcion: "El ubigeo indicado en el comprobante no es el mismo que esta registrado para el contribuyente.",
        tipo:'Observación'
    },
    {
        codigo: "4013",
        descripcion: "El RUC  del receptor no esta activo",
        tipo:'Observación'
    },
    {
        codigo: "4014",
        descripcion: "El RUC del receptor no esta habido",
        tipo:'Observación'
    },
    {
        codigo: "4015",
        descripcion: "Si el tipo de documento del receptor no es RUC, debe tener operaciones de exportacion",
        tipo:'Observación'
    },
    {
        codigo: "4016",
        descripcion: "El total valor venta neta de oper. gravadas IGV debe ser mayor a 0.00 o debe existir oper. gravadas onerosas",
        tipo:'Observación'
    },
    {
        codigo: "4017",
        descripcion: "El total valor venta neta de oper. inafectas IGV debe ser mayor a 0.00 o debe existir oper. inafectas onerosas o de export.",
        tipo:'Observación'
    },
    {
        codigo: "4018",
        descripcion: "El total valor venta neta de oper. exoneradas IGV debe ser mayor a 0.00 o debe existir oper. exoneradas",
        tipo:'Observación'
    },
    {
        codigo: "4019",
        descripcion: "El calculo del IGV no es correcto",
        tipo:'Observación'
    },
    {
        codigo: "4020",
        descripcion: "El ISC no esta informado correctamente",
        tipo:'Observación'
    },
    {
        codigo: "4021",
        descripcion: "Si se utiliza la leyenda con codigo 2000, el importe de percepcion debe ser mayor a 0.00",
        tipo:'Observación'
    },
    {
        codigo: "4022",
        descripcion: "Si se utiliza la leyenda con código 2001, el total de operaciones exoneradas debe ser mayor a 0.00",
        tipo:'Observación'
    },
    {
        codigo: "4023",
        descripcion: "Si se utiliza la leyenda con código 2002, el total de operaciones exoneradas debe ser mayor a 0.00",
        tipo:'Observación'
    },
    {
        codigo: "4024",
        descripcion: "Si se utiliza la leyenda con código 2003, el total de operaciones exoneradas debe ser mayor a 0.00",
        tipo:'Observación'
    },
    {
        codigo: "4025",
        descripcion: "Si usa la leyenda de Transferencia o Servivicio gratuito, todos los items deben ser  no onerosos",
        tipo:'Observación'
    },
    {
        codigo: "4026",
        descripcion: "No se puede indicar Guia de remision de remitente y Guia de remision de transportista en el mismo documento",
        tipo:'Observación'
    },
    {
        codigo: "4027",
        descripcion: "El importe total no coincide con la sumatoria de los valores de venta mas los tributos mas los cargos",
        tipo:'Observación'
    },
    {
        codigo: "4028",
        descripcion: "El monto total de la nota de credito debe ser menor o igual al monto de la factura",
        tipo:'Observación'
    },
    {
        codigo: "4029",
        descripcion: "El ubigeo indicado en el comprobante no es el mismo que esta registrado para el contribuyente",
        tipo:'Observación'
    },
    {
        codigo: "4030",
        descripcion: "El ubigeo indicado en el comprobante no es el mismo que esta registrado para el contribuyente",
        tipo:'Observación'
    },
    {
        codigo: "4031",
        descripcion: "Debe indicar el nombre comercial",
        tipo:'Observación'
    },
    {
        codigo: "4032",
        descripcion: "Si el código del motivo de emisión de la Nota de Credito es 03, debe existir la descripción del item",
        tipo:'Observación'
    },
    {
        codigo: "4033",
        descripcion: "La fecha de generación de la numeración debe ser menor o igual a la fecha de generación de la comunicación",
        tipo:'Observación'
    },
    {
        codigo: "4034",
        descripcion: "El comprobante fue registrado previamente como baja",
        tipo:'Observación'
    },
    {
        codigo: "4035",
        descripcion: "El comprobante fue registrado previamente como rechazado",
        tipo:'Observación'
    },
    {
        codigo: "4036",
        descripcion: "La fecha de emisión de los rangos debe ser menor o igual a la fecha de generación del resumen",
        tipo:'Observación'
    },
    {
        codigo: "4037",
        descripcion: "El calculo del Total de IGV del Item no es correcto",
        tipo:'Observación'
    },
    {
        codigo: "4038",
        descripcion: "El resumen contiene menos series por tipo de documento que el envío anterior para la misma fecha de emisión",
        tipo:'Observación'
    },
    {
        codigo: "4039",
        descripcion: "No ha consignado información del ubigeo del domicilio fiscal",
        tipo:'Observación'
    },
    {
        codigo: "4040",
        descripcion: "Si el importe de percepcion es mayor a 0.00, debe utilizar una leyenda con codigo 2000",
        tipo:'Observación'
    },
    {
        codigo: "4041",
        descripcion: "El codigo de pais debe ser PE",
        tipo:'Observación'
    },
    {
        codigo: "4042",
        descripcion: "Para tipo de operación se está usando un valor que no existe en el catálogo. Nro. 17.",
        tipo:'Observación'
    },
    {
        codigo: "4043",
        descripcion: "Para el TransportModeCode, se está usando un valor que no existe en el catálogo Nro. 18.",
        tipo:'Observación'
    },
    {
        codigo: "4044",
        descripcion: "PrepaidAmount: Monto total anticipado no coincide con la sumatoria de los montos por documento de anticipo.",
        tipo:'Observación'
    },
    {
        codigo: "4045",
        descripcion: "No debe consignar los datos del transportista para la modalidad de transporte 02 – Transporte Privado.",
        tipo:'Observación'
    },
    {
        codigo: "4046",
        descripcion: "No debe consignar información adicional en la dirección para los locales anexos.",
        tipo:'Observación'
    },
    {
        codigo: "4047",
        descripcion: "sac:SUNATTransaction/cbc:ID debe ser igual a 10 o igual a 11 cuando ingrese información para sustentar el traslado.",
        tipo:'Observación'
    },
    {
        codigo: "4048",
        descripcion: "cac:AdditionalDocumentReference/ cbc:DocumentTypeCode - Contiene un valor no valido para documentos relacionado.",
        tipo:'Observación'
    },
    {
        codigo: "4049",
        descripcion: "El numero de DNI del receptor no existe.",
        tipo:'Observación'
    },
    {
        codigo: "4050",
        descripcion: "El numero de RUC del proveedor no existe.",
        tipo:'Observación'
    },
    {
        codigo: "4051",
        descripcion: "El RUC del proveedor no esta activo.",
        tipo:'Observación'
    },
    {
        codigo: "4052",
        descripcion: "El RUC del proveedor no esta habido.",
        tipo:'Observación'
    },
    {
        codigo: "4053",
        descripcion: "Proveedor no debe ser igual al remitente o destinatario.",
        tipo:'Observación'
    },
    {
        codigo: "4054",
        descripcion: "La guía no debe contener datos del proveedor.",
        tipo:'Observación'
    },
    {
        codigo: "4055",
        descripcion: "El XML no contiene el atributo o no existe información en descripcion del motivo de traslado.",
        tipo:'Observación'
    },
    {
        codigo: "4056",
        descripcion: "El XML no contiene el tag o no existe información en el tag SplitConsignmentIndicator.",
        tipo:'Observación'
    },
    {
        codigo: "4057",
        descripcion: "GrossWeightMeasure – El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4058",
        descripcion: "cbc:TotalPackageQuantity - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4059",
        descripcion: "Numero de bultos o pallets - información válida para importación.",
        tipo:'Observación'
    },
    {
        codigo: "4060",
        descripcion: "La guía no debe contener datos del transportista.",
        tipo:'Observación'
    },
    {
        codigo: "4061",
        descripcion: "El numero de RUC del transportista no existe.",
        tipo:'Observación'
    },
    {
        codigo: "4062",
        descripcion: "El RUC del transportista no esta activo.",
        tipo:'Observación'
    },
    {
        codigo: "4063",
        descripcion: "El RUC del transportista no esta habido.",
        tipo:'Observación'
    },
    {
        codigo: "4064",
        descripcion: "/DespatchAdvice/cac:Shipment/ cac:ShipmentStage/cac:TransportMeans/ cbc:RegistrationNationalityID - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4065",
        descripcion: "cac:TransportMeans/cbc:TransportMeansTypeCode - El valor ingresado como tipo de unidad de transporte es incorrecta.",
        tipo:'Observación'
    },
    {
        codigo: "4066",
        descripcion: "El numero de DNI del conductor no existe.",
        tipo:'Observación'
    },
    {
        codigo: "4067",
        descripcion: "El XML no contiene el tag o no existe informacion del ubigeo del punto de llegada.",
        tipo:'Observación'
    },
    {
        codigo: "4068",
        descripcion: "Direccion de punto de lllegada - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4069",
        descripcion: "CityName - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4070",
        descripcion: "District - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4071",
        descripcion: "Numero de Contenedor - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4072",
        descripcion: "Numero de contenedor - información válida para importación.",
        tipo:'Observación'
    },
    {
        codigo: "4073",
        descripcion: "TransEquipmentTypeCode - El valor ingresado como tipo de contenedor es incorrecta.",
        tipo:'Observación'
    },
    {
        codigo: "4074",
        descripcion: "Numero Precinto - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4075",
        descripcion: "El XML no contiene el tag o no existe informacion del ubigeo del punto de partida.",
        tipo:'Observación'
    },
    {
        codigo: "4076",
        descripcion: "Direccion de punto de partida - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4077",
        descripcion: "CityName - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4078",
        descripcion: "District - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4079",
      descipcion: "codigo de Puerto o Aeropuerto - El dato ingresado no cumple con el formato establecido.",
      tipo:'Observación'
    },
    {
        codigo: "4080",
        descripcion: "Tipo de Puerto o Aeropuerto - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4081",
        descripcion: "El XML No contiene El tag o No existe información del Numero de orden del item.",
        tipo:'Observación'
    },
    {
        codigo: "4082",
        descripcion: "Número de Orden del Ítem - El orden del ítem no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4083",
        descripcion: "Cantidad - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4084",
        descripcion: "Descripción del Ítem - El dato ingresado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
      codigo: "4085",
      descipcion: "codigo del Ítem - El dato ingresado no cumple con el formato establecido.",
      tipo:'Observación'
    },
    {
        codigo: "4086",
        descripcion: "El emisor y el cliente son Agentes de percepción de combustible en la fecha de emisión.",
        tipo:'Observación'
    },
    {
        codigo: "4087",
        descripcion: "El Comprobante de Pago Electrónico no está Registrado en los Sistemas de la SUNAT.",
        tipo:'Observación'
    },
    {
        codigo: "4088",
        descripcion: "El Comprobante de Pago no está autorizado en los Sistemas de la SUNAT.",
        tipo:'Observación'
    },
    {
        codigo: "4089",
        descripcion: "La operación con este cliente está excluida del sistema de percepción. Es agente de retención.",
        tipo:'Observación'
    },
    {
        codigo: "4090",
        descripcion: "La operación con este cliente está excluida del sistema de percepción. Es entidad exceptuada de la percepción.",
        tipo:'Observación'
    },
    {
        codigo: "4091",
        descripcion: "La operación con este proveedor está excluida del sistema de retención. Es agente de percepción, agente de retención o buen contribuyente.",
        tipo:'Observación'
    },
    {
        codigo: "4092",
        descripcion: "El nombre comercial del emisor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4093",
        descripcion: "El codigo de ubigeo del domicilio fiscal del emisor no es válido",
        tipo:'Observación'
    },
    {
        codigo: "4094",
        descripcion: "La dirección completa y detallada del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4095",
        descripcion: "La urbanización del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4096",
        descripcion: "La provincia del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4097",
        descripcion: "El departamento del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4098",
        descripcion: "El distrito del domicilio fiscal del emisor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4099",
        descripcion: "El nombre comercial del cliente no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4100",
        descripcion: "El ubigeo del cliente no cumple con el formato establecido o no es válido",
        tipo:'Observación'
    },
    {
        codigo: "4101",
        descripcion: "La dirección completa y detallada del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4102",
        descripcion: "La urbanización del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4103",
        descripcion: "La provincia del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4104",
        descripcion: "El departamento del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4105",
        descripcion: "El distrito del domicilio fiscal del cliente no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4106",
        descripcion: "El nombre comercial del proveedor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4107",
        descripcion: "El ubigeo del proveedor no cumple con el formato establecido o no es válido",
        tipo:'Observación'
    },
    {
        codigo: "4108",
        descripcion: "La dirección completa y detallada del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4109",
        descripcion: "La urbanización del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4110",
        descripcion: "La provincia del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4111",
        descripcion: "El departamento del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4112",
        descripcion: "El distrito del domicilio fiscal del proveedor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4120",
        descripcion: "El XML no contiene o no existe informacion en el tag de  Información que sustenta el traslado.",
        tipo:'Observación'
    },
    {
        codigo: "4121",
        descripcion: "Para el tipo de operación no se consigna el tag SUNATEmbededDespatchAdvice de Información de sustento de traslado.",
        tipo:'Observación'
    },
    {
        codigo: "4122",
        descripcion: "Factura con información que sustenta el traslado, debe registrar leyenda 2008.",
        tipo:'Observación'
    },
    {
        codigo: "4123",
        descripcion: "sac:SUNATEmbededDespatchAdvice - Para Factura Electrónica Remitente no se consigna datos en documento de referencia(cac:OrderReference).",
        tipo:'Observación'
    },
    {
        codigo: "4124",
        descripcion: "cac:Shipment - Para Factura Electrónica Remitente debe indicar sujeto que realiza el traslado de bienes (1: Vendendor o 2: Comprador).",
        tipo:'Observación'
    },
    {
        codigo: "4125",
        descripcion: "cac:Shipment - Para Factura Electrónica Remitente debe indicar modalidad de transporte para el sustento de traslado de bienes (cbc:TransportModeCode).",
        tipo:'Observación'
    },
    {
        codigo: "4126",
        descripcion: "cac:Shipment - Debe indicar fecha de inicio de traslado para el  sustento de traslado de bienes (cac:TransitPeriod/cbc:StartDate).",
        tipo:'Observación'
    },
    {
        codigo: "4127",
        descripcion: "cac:Shipment - Para Factura Electrónica Remitente debe indicar el punto de llegada para el sustento de traslado de bienes (cac:DeliveryAddrees).",
        tipo:'Observación'
    },
    {
        codigo: "4128",
        descripcion: "cac:Shipment - Para Factura Electrónica Remitente debe indicar el punto de partida para el sustento de traslado de bienes (cac:OriginAddress).",
        tipo:'Observación'
    },
    {
        codigo: "4129",
        descripcion: "Para Factura Electrónica Remitente no se consigna indicador de subcontratación (cbc:MarkAttentionIndicator)",
        tipo:'Observación'
    },
    {
        codigo: "4130",
        descripcion: "sac:SUNATEmbededDespatchAdvice - Para Factura Electrónica Remitente debe consignar datos en documento de referencia (cac:OrderReference).",
        tipo:'Observación'
    },
    {
        codigo: "4131",
        descripcion: "sac:SUNATEmbededDespatchAdvice - Para Factura Electrónica Transportista no se consigna destinatario para el sustento de traslado de bienes (cac:DeliveryCustomerParty).",
        tipo:'Observación'
    },
    {
        codigo: "4132",
        descripcion: "cac:Shipment - Para Factura Electrónica Transportista no se consigna sujeto que realiza el traslado (cbc:HandlingCode).",
        tipo:'Observación'
    },
    {
        codigo: "4133",
        descripcion: "Para Factura Electrónica Transportista no se consigna peso total de la factura para el sustento de traslado de bienes (cbc:GrossWeightMeasure).",
        tipo:'Observación'
    },
    {
        codigo: "4134",
        descripcion: "cac:Shipment - Para Factura Electrónica Transportista no se consigna modalidad de transporte para el sustento de traslado de bienes (cbc:TransportModeCode).",
        tipo:'Observación'
    },
    {
        codigo: "4135",
        descripcion: "cac:Shipment - Para Factura Electrónica Transportista no se consigna punto de llegada para el sustento de traslado de bienes (cac:DeliveryAddress).",
        tipo:'Observación'
    },
    {
        codigo: "4136",
        descripcion: "cac:Shipment - Para Factura Electrónica Transportista no se consigna punto de partida para el sustento de traslado de bienes (cac:OriginAddress).",
        tipo:'Observación'
    },
    {
        codigo: "4137",
        descripcion: "cac:OrderReference - Debe consignar número de  documento de referencia que sustenta el traslado (./cbc:ID).",
        tipo:'Observación'
    },
    {
        codigo: "4138",
        descripcion: "cac:OrderReference - Debe consignar tipo de documento de referencia que sustenta el traslado (./cbc:OrderTypeCode).",
        tipo:'Observación'
    },
    {
        codigo: "4139",
        descripcion: "cac:OrderReference - Tipo de documento de referencia que sustenta el traslado no válido (01 – Factura o 09 – Guía de Remisión).",
        tipo:'Observación'
    },
    {
        codigo: "4140",
        descripcion: "cac:OrderReference - Serie-Numero ingresado en documento de referencia que sustenta el traslado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4141",
        descripcion: "cac:OrderReference - Debe consignar RUC emisor del documento de referencia que sustenta el traslado .",
        tipo:'Observación'
  
    },
    {
        codigo: "4142",
        descripcion: "cac:OrderReference -  RUC emisor del documento de referencia que sustenta el traslado no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4143",
        descripcion: "cac:OrderReference – RUC Emisor de documento de referencia que sustenta el traslado no existe o se encuentra dado de baja.",
        tipo:'Observación'
    },
    {
        codigo: "4144",
        descripcion: "cac:OrderReference – Documento de Referencia ingresado no corresponde a un comprobante electrónico declarado y activo en SUNAT.",
        tipo:'Observación'
    },
    {
        codigo: "4145",
        descripcion: "cac:OrderReference – Documento de Referencia ingresado no corresponde comprobante autorizado por SUNAT.",
        tipo:'Observación'
    },
    {
        codigo: "4146",
        descripcion: "cac:OrderReference - Nombre o razon social del emisodr de referencia que sustenta el traslado de bienes no cumple con un formato válido.",
        tipo:'Observación'
    },
    {
        codigo: "4147",
        descripcion: "Debe consignar numero de documento de identidad del destinatario",
        tipo:'Observación'
    },
    {
        codigo: "4148",
        descripcion: "Debe consignar tipo de documento de identidad del destinatario",
        tipo:'Observación'
    },
    {
        codigo: "4149",
        descripcion: "Tipo de documento de identidad del destinatario no válido (Catálogo N° 06)",
        tipo:'Observación'
    },
    {
        codigo: "4150",
        descripcion: "Numero de documento de identidad del destinatario no cumple con un formato válido",
        tipo:'Observación'
    },
    {
        codigo: "4151",
        descripcion: "Debe consignar apellidos y nombres, denominación o razón social del destinatario",
        tipo:'Observación'
    },
    {
        codigo: "4152",
        descripcion: "Nombre o razon social del destinatario no cumple con un formato válido",
        tipo:'Observación'
    },
    {
        codigo: "4153",
        descripcion: "cbc:HandlingCode - Sujeto que realiza el traslado no es valido.",
        tipo:'Observación'
    },
    {
        codigo: "4154",
        descripcion: "cbc:GrossWeightMeasure@unitCode: El valor ingresado en la unidad de medida para el peso bruto total no es correcta (KGM).",
        tipo:'Observación'
    },
    {
        codigo: "4155",
        descripcion: "GrossWeightMeasure – El valor ingresado no cumple con el estandar.",
        tipo:'Observación'
    },
    {
        codigo: "4156",
        descripcion: "Debe ingresar la totalidad de la información requerida al transportista.",
        tipo:'Observación'
    },
    {
        codigo: "4157",
        descripcion: "No existe información en el tag datos de conductores.",
        tipo:'Observación'
    },
    {
        codigo: "4158",
        descripcion: "No existe información en el tag datos de vehículos.",
        tipo:'Observación'
    },
    {
        codigo: "4159",
        descripcion: "No es necesario consignar los datos del transportista para una operación de Transporte Privado.",
        tipo:'Observación'
    },
    {
        codigo: "4160",
        descripcion: "cac:CarrierParty: Debe consignar número de  documento de identidad del transportista.",
        tipo:'Observación'
    },
    {
        codigo: "4161",
        descripcion: "cac:CarrierParty: Debe consignar tipo de documento de identidad del transportista.",
        tipo:'Observación'
    },
    {
        codigo: "4162",
        descripcion: "cac:CarrierParty: Tipo de documento de identidad del transportista debe ser 6-RUC",
        tipo:'Observación'
    },
    {
        codigo: "4163",
        descripcion: "cac:CarrierParty: Numero de documento de identidad del transportista no cumple con un formato válido.",
        tipo:'Observación'
    },
    {
        codigo: "4164",
        descripcion: "cac:CarrierParty: Debe consignar apellidos y nombres, denominación o razón social del transportista.",
        tipo:'Observación'
    },
    {
        codigo: "4165",
        descripcion: "cac:CarrierParty: nombre o razon social del transportista no cumple con un formato válido.",
        tipo:'Observación'
    },
    {
        codigo: "4166",
        descripcion: "cac: TransportHandlingUnit: Numero de placa (cbc:ID) no coincide con el numero de placa del vehiculo prinicipal.",
        tipo:'Observación'
    },
    {
        codigo: "4167",
        descripcion: "cac:RoadTransport/cbc:LicensePlateID: Numero de placa del vehículo no cumple con el formato válido.",
        tipo:'Observación'
    },
    {
        codigo: "4168",
        descripcion: "cac: TransportHandlingUnit: Numero de placa del vehículo principal no existe o no cumple con el formato válido (cbc:ID).",
        tipo:'Observación'
    },
    {
        codigo: "4169",
        descripcion: "cac:TransportEquipment: debe consignar al menos un vehiculo secundario.",
        tipo:'Observación'
    },
    {
        codigo: "4170",
        descripcion: "cac:TransportEquipment: Numero de placa del vehículo secundario no cumple con el formato válido (cbc:ID).",
        tipo:'Observación'
    },
    {
        codigo: "4171",
        descripcion: "cac:DriverPerson: Debe consignar número de  documento de identidad del conductor (cbc:ID).",
        tipo:'Observación'
    },
    {
        codigo: "4172",
        descripcion: "cac:DriverPerson: Debe consignar tipo de documento de identidad del conductor (cbc:ID/@schemeID).",
        tipo:'Observación'
    },
    {
        codigo: "4173",
        descripcion: "cac:DriverPerson: Tipo de documento de identidad del conductor no válido (Catalogo Nro 06).",
        tipo:'Observación'
    },
    {
        codigo: "4174",
        descripcion: "cac:DriverPerson: Numero de documento de identidad del conductor no cumple con el formato válido.",
        tipo:'Observación'
    },
    {
        codigo: "4175",
        descripcion: "cac:DeliveryAddress: Debe consignar código de ubigeo de punto de llegada (cbc:ID).",
        tipo:'Observación'
    },
    {
        codigo: "4176",
        descripcion: "El dato ingresado como código de ubigeo de punto de llegada no corresponde a un valor esperado (catalogo nro 13).",
        tipo:'Observación'
    },
    {
        codigo: "4177",
        descripcion: "cac:DeliveryAddress: Debe consignar código de ubigeo válido (Catálogo N° 13).",
        tipo:'Observación'
    },
    {
        codigo: "4178",
        descripcion: "cac:DeliveryAddress: Debe consignar Dirección del punto de llegada (cbc:StreetName).",
        tipo:'Observación'
    },
    {
        codigo: "4179",
        descripcion: "cac:DeliveryAddress: Dirección completa y detallada del punto de llegada no cumple con el formato válido.",
        tipo:'Observación'
    },
    {
        codigo: "4180",
        descripcion: "cac:OriginAddress: Debe consignar código de ubigeo de punto de partida (cbc:ID).",
        tipo:'Observación'
    },
    {
        codigo: "4181",
        descripcion: "El dato ingresado como código de ubigeo de punto de partida no corresponde a un valor esperado (catalogo nro 13).",
        tipo:'Observación'
    },
    {
        codigo: "4182",
        descripcion: "cac:OriginAddress: Debe consignar código de ubigeo válido (Catálogo N° 13).",
        tipo:'Observación'
    },
    {
        codigo: "4183",
        descripcion: "cac:OriginAddress: Debe consignar Dirección detallada del punto de partida (cbc:StreetName).",
        tipo:'Observación'
    },
    {
        codigo: "4184",
        descripcion: "cac:OriginAddres: Dirección completa y detallada del punto de partida no cumple con el estandar.",
        tipo:'Observación'
    },
    {
        codigo: "4185",
        descripcion: "cac:OrderReference - Serie y numero no se encuentra registrado como baja por cambio de destinatario.",
        tipo:'Observación'
    },
    {
        codigo: "4186",
        descripcion: "cbc:Note - El campo observaciones supera la cantidad maxima especificada (250 carácteres).",
        tipo:'Observación'
    },
    {
        codigo: "4187",
        descripcion: "cac:OrderReference - El campo Tipo de documento (descripción) supera la cantidad maxima especificada (50 carácteres).",
        tipo:'Observación'
    },
    {
        codigo: "4188",
        descripcion: "El XML no contiene el atributo o no existe información del nombre o razon social del tercero relacionado.",
        tipo:'Observación'
    },
    {
        codigo: "4189",
        descripcion: "El valor ingresado como tipo de documento del nombre o razon social del tercero relacionado es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4190",
        descripcion: "El valor ingresado como descripcion de motivo de traslado no cumple con el estandar.",
        tipo:'Observación'
    },
    {
        codigo: "4191",
        descripcion: "Para el motivo de traslado, no se consigna información en el numero de DAM.",
        tipo:'Observación'
    },
    {
        codigo: "4192",
        descripcion: "Para el motivo de traslado, no se consigna información del manifiesto de carga.",
        tipo:'Observación'
    },
    {
        codigo: "4193",
        descripcion: "El valor ingresado como indicador de transbordo programado no cumple con el estandar.",
        tipo:'Observación'
    },
    {
        codigo: "4194",
        descripcion: "El XML no contiene el atributo o no existe información en peso bruto total de la guia.",
        tipo:'Observación'
    },
    {
        codigo: "4195",
        descripcion: "Numero de bultos o pallets es una información válida solo para importación.",
        tipo:'Observación'
    },
    {
        codigo: "4196",
        descripcion: "La fecha de recepción en SUNAT es mayor a 1 hora(s) respecto a la fecha de comprobación por OSE",
        tipo:'Observación'
    },
    {
        codigo: "4197",
        descripcion: "IssueTime - El dato ingresado  no cumple con el patrón hh:mm:ss.sssss",
        tipo:'Observación'
    },
    {
        codigo: "4200",
        descripcion: "Debe corresponder a algún valor válido establecido en el catálogo 13",
        tipo:'Observación'
    },
    {
        codigo: "4201",
        descripcion: "EL monto del ISC se debe detallar a nivel de línea",
        tipo:'Observación'
    },
    {
        codigo: "4202",
        descripcion: "El valor ingresado como numero de DAM no cumple con el estandar",
        tipo:'Observación'
    },
    {
        codigo: "4207",
        descripcion: "El DNI debe tener 8 caracteres numéricos",
        tipo:'Observación'
    },
    {
        codigo: "4208",
        descripcion: "El dato ingresado como numero de documento de identidad del receptor no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4230",
        descripcion: "el Comprobante no debió ser observado.",
        tipo:'Observación'
    },
    {
        codigo: "4231",
        descripcion: "El código de Ubigeo no existe en el listado.",
        tipo:'Observación'
    },
    {
        codigo: "4232",
        descripcion: "La sumatoria de los IGV de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4233",
        descripcion: "El dato ingresado en order de compra no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4234",
        descripcion: "El código de producto no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4235",
        descripcion: "No existe información en el nombre del concepto.",
        tipo:'Observación'
    },
    {
        codigo: "4236",
        descripcion: "El dato ingresado como direccion completa y detallada no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4237",
        descripcion: "La tasa del tributo de la línea no corresponde al valor esperado",
        tipo:'Observación'
    },
    {
        codigo: "4238",
        descripcion: "El dato ingresado como urbanización no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4239",
        descripcion: "El dato ingresado como provincia no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4240",
        descripcion: "El dato ingresado como departamento no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4241",
        descripcion: "El dato ingresado como distrito no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4242",
        descripcion: "El dato ingresado como local anexo no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4243",
        descripcion: "Si se utiliza la leyenda con código 2007, el total de operaciones exoneradas debe ser mayor a 0.00",
        tipo:'Observación'
    },
    {
        codigo: "4244",
        descripcion: "Si se utiliza la leyenda con código 2008, el total de operaciones exoneradas debe ser mayor a 0.00",
        tipo:'Observación'
    },
    {
        codigo: "4245",
        descripcion: "El dato ingresado como tipo de operación no corresponde a un valor esperado (catálogo nro. 51)",
        tipo:'Observación'
    },
    {
        codigo: "4246",
        descripcion: "El comprobante contiene un identificador de pago repetido en los anticipos",
        tipo:'Observación'
    },
    {
        codigo: "4247",
        descripcion: "El comprobante contiene un identificador de pago no relacionado a un documento de anticipo",
        tipo:'Observación'
    },
    {
        codigo: "4248",
        descripcion: "El comprobante contiene mas de un documento de anticipo relacionado al mismo identificador de pago.",
        tipo:'Observación'
    },
    {
        codigo: "4249",
        descripcion: "El código de motivo de traslado no existe en el listado (catalogo nro. 20)",
        tipo:'Observación'
    },
    {
        codigo: "4250",
        descripcion: "El dato ingresado como schemeAgencyName es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4251",
        descripcion: "El dato ingresado como atributo @listAgencyName es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4252",
        descripcion: "El dato ingresado como atributo @listName es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4253",
        descripcion: "El dato ingresado como atributo @listURI es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4254",
        descripcion: "El dato ingresado como atributo @listID es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4255",
        descripcion: "El dato ingresado como atributo @schemeName es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4256",
        descripcion: "El dato ingresado como atributo @schemeAgencyName es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4257",
        descripcion: "El dato ingresado como atributo @schemeURI es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4258",
        descripcion: "El dato ingresado como atributo @unitCodeListID es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4259",
        descripcion: "El dato ingresado como atributo @unitCodeListAgencyName es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4260",
        descripcion: "El dato ingresado como atributo @name es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4261",
        descripcion: "El dato ingresado como atributo @listSchemeURI es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4262",
        descripcion: "El XML no contiene el atributo o no existe lugar donde se entrega el bien para venta itinerante",
        tipo:'Observación'
    },
    {
        codigo: "4263",
        descripcion: "Si no es una venta itinerante, no corresponde consignar lugar donde se entrega el bien ",
        tipo:'Observación'
    },
    {
        codigo: "4264",
        descripcion: "El XML no contiene el codigo de leyenda 2007 para el tipo de operación IVAP",
        tipo:'Observación'
    },
    {
        codigo: "4265",
        descripcion: "El XML no contiene el codigo de leyenda 2006 para tipo de operación de detracciones",
        tipo:'Observación'
    },
    {
        codigo: "4266",
        descripcion: "El XML no contiene el codigo de leyenda 2005 para el tipo de operación Venta itinerante",
        tipo:'Observación'
    },
    {
        codigo: "4267",
        descripcion: "El dato ingresado como codigo de producto GS1 no cumple con el formato establecido",
        tipo:'Observación'
    },
    {
        codigo: "4268",
        descripcion: "El dato ingresado como cargo/descuento no es valido a nivel de ítem.",
        tipo:'Observación'
    },
    {
        codigo: "4269",
        descripcion: "El dato ingresado como codigo de producto no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4270",
        descripcion: "El dato ingresado como detalle del viaje no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4271",
        descripcion: "El dato ingresado como descripcion del tramo no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4272",
        descripcion: "El dato ingresado como valor refrencia del tramo virtual no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4273",
        descripcion: "El dato ingresado como configuración vehicular no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4274",
        descripcion: "El dato ingresado como tipo de carga util es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4275",
        descripcion: "El XML no contiene el tag o no existe información del valor de la carga en TM.",
        tipo:'Observación'
    },
    {
        codigo: "4276",
        descripcion: "El dato ingresado como valor de la carga en TM cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4277",
        descripcion: "El dato ingresado como unidad de medida de la carga  del vehiculo no corresponde al valor esperado.",
        tipo:'Observación'
    },
    {
        codigo: "4278",
        descripcion: "El dato ingresado como valor referencial de carga util nominal no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4279",
        descripcion: "El dato ingresado como codigo de identificación de concepto tributario no es valido (catalogo nro 55)",
        tipo:'Observación'
    },
    {
        codigo: "4280",
        descripcion: "El dato ingresado como valor del concepto de la linea no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4281",
        descripcion: "El dato ingresado como cantidad del concepto de la linea no cumple con el formato establecido.",
        tipo:'Observación'
    },
    {
        codigo: "4282",
        descripcion: "La fecha de ingreso al establecimiento es mayor a la fecha de salida al establecimiento.",
        tipo:'Observación'
    },
    {
        codigo: "4283",
        descripcion: "El dato ingresado como atributo @schemeID es incorrecto.",
        tipo:'Observación'
    },
    {
        codigo: "4284",
        descripcion: "El cargo/descuento consignado no es permitido para el tipo de comprobante",
        tipo:'Observación'
    },
    {
        codigo: "4285",
        descripcion: "El emisor a la fecha no se encuentra registrado ó habilitado con la condición de Agente de percepción",
        tipo:'Observación'
    },
    {
        codigo: "4286",
        descripcion: "Si ha consignado Transporte Publico, debe consignar Datos del transportista.",
        tipo:'Observación'
    },
    {
        codigo: "4287",
        descripcion: "El precio unitario de la operación que está informando difiere de los cálculos realizados en base a la información remitida",
        tipo:'Observación'
    },
    {
        codigo: "4288",
        descripcion: "El valor de venta por ítem difiere de los importes consignados.",
        tipo:'Observación'
    },
    {
        codigo: "4289",
        descripcion: "El valor de cargo/descuento por ítem difiere de los importes consignados.",
        tipo:'Observación'
    },
    {
        codigo: "4290",
        descripcion: "El cálculo del IGV es Incorrecto",
        tipo:'Observación'
    },
    {
        codigo: "4291",
        descripcion: "El dato ingresado como cargo/descuento no es valido a nivel global.",
        tipo:'Observación'
    },
    {
        codigo: "4292",
        descripcion: "La Versión del UBL 2.0 se aceptará solo hasta el 30 de junio de 2019",
        tipo:'Observación'
    },
    {
        codigo: "4293",
        descripcion: "El importe total de impuestos por línea no coincide con la sumatoria de los impuestos por línea.",
        tipo:'Observación'
    },
    {
        codigo: "4294",
        descripcion: "La base imponible a nivel de línea difiere de la información consignada en el comprobante",
        tipo:'Observación'
    },
    {
        codigo: "4295",
        descripcion: "La sumatoria del total valor de venta - Exportaciones de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4296",
        descripcion: "La sumatoria del total valor de venta - operaciones inafectas de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4297",
        descripcion: "La sumatoria del total valor de venta - operaciones exoneradas de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4298",
        descripcion: "La sumatoria del total valor de venta - operaciones gratuitas de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4299",
        descripcion: "La sumatoria del total valor de venta - operaciones gravadas de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4300",
        descripcion: "La sumatoria del total valor de venta - IVAP de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4301",
        descripcion: "La sumatoria de impuestos globales no corresponde al monto total de impuestos.",
        tipo:'Observación'
    },
    {
        codigo: "4302",
        descripcion: "El importe del IVAP no corresponden al determinado por la informacion consignada.",
        tipo:'Observación'
    },
    {
        codigo: "4303",
        descripcion: "La sumatoria del total valor de venta - ISC de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4304",
        descripcion: "La sumatoria del total valor de venta - Otros tributos de pago de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4305",
        descripcion: "La sumatoria del total del importe del tributo ISC de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4306",
        descripcion: "La sumatoria del total del importe del tributo Otros tributos de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4307",
        descripcion: "La sumatoria consignados en descuentos globales no corresponden al total.",
        tipo:'Observación'
    },
    {
        codigo: "4308",
        descripcion: "La sumatoria consignados en cargos globales no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4309",
        descripcion: "La sumatoria de valor de venta no corresponde a los importes consignados",
        tipo:'Observación'
    },
    {
        codigo: "4310",
        descripcion: "La sumatoria del Total del valor de venta más los impuestos no concuerda con la base imponible",
        tipo:'Observación'
    },
    {
        codigo: "4311",
        descripcion: "La sumatoria de los IGV de operaciones gratuitas de la línea (codigo tributo 9996) no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4312",
        descripcion: "El importe total del comprobante no coincide con el valor calculado",
        tipo:'Observación'
    },
    {
        codigo: "4313",
        descripcion: "El dato ingresado como unidad de medida de los dias de permanencia no corresponde al valor esperado.",
        tipo:'Observación'
    },
    {
        codigo: "4314",
        descripcion: "El monto para el redondeo del Importe Total excede el valor permitido",
        tipo:'Observación'
    },
    {
        codigo: "4315",
        descripcion: "La moneda debe ser la misma en todo el documento. Salvo las percepciones que sólo son en moneda nacional.",
        tipo:'Observación'
    },
    {
        codigo: "4316",
        descripcion: "La moneda del monto para el redondeo debe ser PEN",
        tipo:'Observación'
    },
    {
        codigo: "4317",
        descripcion: "Debe consignar el Total Precio de Venta",
        tipo:'Observación'
    },
    {
        codigo: "4318",
        descripcion: "El dato ingresado en el campo cac:TaxSubtotal/cbc:TaxAmount del ítem no coincide con el valor calculado",
        tipo:'Observación'
    },
    {
        codigo: "4320",
        descripcion: "El dato ingresado como unidad de medida no corresponde al valor esperado",
        tipo:'Observación'
    },
    {
        codigo: "4321",
        descripcion: "La sumatoria del total del importe del tributo ICBPER de línea no corresponden al total",
        tipo:'Observación'
    },
    {
        codigo: "4322",
        descripcion: "El valor de cargo/descuento global difiere de los importes consignados",
        tipo:'Observación'
    },
    {
        codigo: "4323",
        descripcion: "El dato ingresado como tipo de usuario no corresponde al valor esperado",
        tipo:'Observación'
    },
    {
        codigo: "4324",
        descripcion: "El dato ingresado como tipo de tarifa contratada no corresponde al valor esperado",
        tipo:'Observación'
    },
    {
        codigo: "4326",
        descripcion: "Para Factura Electrónica Transportista debe indicar el número de constancia de inscripcion del vehiculo o certificado de habilitación vehicular",
        tipo:'Observación'
    },
    {
        codigo: "4327",
        descripcion: "Para Factura Electrónica Transportista debe consignar el indicador de subcontratacion",
        tipo:'Observación'
    },
    {
        codigo: "4328",
        descripcion: "El valor del indicador de subcontratacion no corresponde al valor esperado",
        tipo:'Observación'
    },
    {
        codigo: "4329",
        descripcion: "Para factura electrónica remitente debe consignar el motivo de traslado",
        tipo:'Observación'
    },
    {
        codigo: "4330",
        descripcion: "Para factura electrónica tranportista debe indicar la GRE remitente o FE remitente  ",
        tipo:'Observación'
    },
    {
        codigo: "4331",
        descripcion: "Debe consignar obligatoriamente Codigo de producto SUNAT o Codigo de producto GTIN",
        tipo:'Observación'
    },
    {
        codigo: "4332",
      descipcion: "El codigo producto de SUNAT no es válido",
      tipo:'Observación'
    },
    {
        codigo: "4333",
        descripcion: "Si utiliza el estandar GS1 debe especificar el tipo de estructura GTIN",
        tipo:'Observación'
    },
    {
        codigo: "4334",
        descripcion: "El código de producto GS1 no cumple el estandar",
        tipo:'Observación'
    },
    {
        codigo: "4335",
        descripcion: "El tipo de estructura GS1 no tiene un valor permitido",
        tipo:'Observación'
    },
    {
        codigo: "4337",
        descripcion: "El Codigo de producto SUNAT debe especificarse como minimo al tercer nivel jerarquico (a nivel de clase del codigo UNSPSC)",
        tipo:'Observación'
    },
    {
        codigo: "4338",
        descripcion: "RegistrationName - El nombre o razon social del emisor no cumple con el estandar",
        tipo:'Observación'
    }
  ]
  