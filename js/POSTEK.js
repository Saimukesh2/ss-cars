var printparamsJsonArray = [];
var url = "http://127.0.0.1:888/postek/print";
     
/*Clear data*/
function clean(){
printparamsJsonArray=[];
}


/**
*@description log function
* =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
*/

/**
* @description Turn on the log function and specify the log generation path
* @param {String} filePath specifies the path of the generated log
*/
function PTK_OpenLogMode(filePath){
printparamsJsonArray.push({"PTK_OpenLogMode" : filePath});
   }

     /**
* @description disable logging
*/
function PTK_CloseLogMode(){
printparamsJsonArray.push({"PTK_CloseLogMode" : ""});
     }
  
  
/**
* @@description printer communication
* =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
*/
   
     /**
* @description Open the USB communication port
* @param {Number} px USB port number, the value range is 1-255; the value is 255 if only one printer is connected to the PC. If there are multiple printers, please use PTK_GetAllPrinterUSBInfo to obtain
*/
     function PTK_OpenUSBPort(px){
printparamsJsonArray.push({"PTK_OpenUSBPort" : px});
}

/**
* @description Close the USB communication port; after opening the port, you need to close the port after printing
*/
function PTK_CloseUSBPort(){
printparamsJsonArray.push({"PTK_CloseUSBPort" : ""});
}

    
/**
* @description connect printer network
* @param {String} IPAddress printer IP address
* @param {Number} Port printer network port
*/
function PTK_Connect(IPAddress,Port){
printparamsJsonArray.push({"PTK_Connect":IPAddress+","+Port});
}


/**
* @description connect to the printer network, you can set the connection timeout time
* @param {String} IPAddress printer ip address
* @param {Number} Port printer network port
* @param {Number} time timeout
*/
function PTK_Connect_Timer(IPAddress,Port,time) {
printparamsJsonArray.push({"PTK_Connect_Timer":IPAddress+","+Port+","+time});
}


/**
* @description close the printer network port
*/
function PTK_CloseConnect(){
printparamsJsonArray.push({"PTK_CloseConnect":""});
}

/**
* @description Open a serial port
* @param {Number} port serial port number, the value range is 1~255
* @param {Number} bRate The serial port baud rate of the printer, the value is 9600, 19200, 38400, 57600
*/
function PTK_OpenSerialPort(port,bRate){
printparamsJsonArray.push({"PTK_OpenSerialPort":port+","+bRate});
}

/**
* @description close the opened serial port
*/
function PTK_CloseSerialPort(){
printparamsJsonArray.push({"PTK_CloseSerialPort":""});
}


/**
* @description Open a printer driver; the driver port only supports sending data to the printer, not reading data from the printer.
* @param {String} printerName printer name
*/
     function PTK_OpenPrinter(printerName){
printparamsJsonArray.push({"PTK_OpenPrinter" : printerName});
}


/**
* @description close the opened printer driver
*/
function PTK_ClosePrinter(){
printparamsJsonArray.push({"PTK_ClosePrinter":""});
}


/**
* @description open a parallel port
* @param {Number} port parallel port number, the value range is 1~3
*/
function PTK_OpenParallelPort(port){
printparamsJsonArray.push({"PTK_OpenParallelPort" : port});
}



/**
* @description Creates a file to which data sent to the printer will be written. Note: Each call will recreate the file, overwriting the previous content.
* @param {Number} fn file path to create
*/
function PTK_OpenTextPort(fn){
printparamsJsonArray.push({"PTK_OpenTextPort" : fn});
}


/**
* @description close the opened file
*/
function PTK_CloseTextPort(){
printparamsJsonArray.push({"PTK_CloseTextPort":""});
}


/**
* @description creates a buffer, the content sent to the printer will be written to the buffer, and a USB port is opened; calling PTK_WriteBuffToPrinter will send the content of the buffer to the open port in one go
* @param {Number} portNum USB port number. The value range is 1~255
*/
function PTK_OpenUSBPort_Buff(portNum){
printparamsJsonArray.push({"PTK_OpenUSBPort_Buff" : portNum});
}


/**
* @description creates a buffer, the content sent to the printer will be written to the buffer, and a driver port is opened; calling PTK_WriteBuffToPrinter will send the content of the buffer to the open port in one go
* @param {String} printer name
*/
function PTK_OpenPrinter_Buff(portNum){
printparamsJsonArray.push({"PTK_OpenPrinter_Buff" : portNum});
}

/**
* @description release buffer, close open port
*/
function PTK_CloseBuffPort(){
printparamsJsonArray.push({"PTK_CloseBuffPort":""});
}

/**
* @description Send the content of the buffer to the open port; please do not call the API function with the function of reading data in the buffer, otherwise the port will be blocked
*/
function PTK_WriteBuffToPrinter(){
printparamsJsonArray.push({"PTK_WriteBuffToPrinter":""});
}


/**
* @description creates a buffer, the content sent to the printer will be written to the buffer, and a network port is opened; calling PTK_WriteBuffToPrinter will send the content of the buffer to the open port in one go
* @param {String} IPAddr IP address of the printer
* @param {String} netPort The network port of the printer (usually 9100
* @param {Number} time_sec Set the maximum time to wait for the connection, in seconds
*/
function PTK_Connect_Timer_Buff(IPAddr,netPort,time_sec) {
printparamsJsonArray.push({"PTK_Connect_Timer_Buff":IPAddr+","+netPort+","+time_sec});
}


     /**
* @description send file content to printer
* @param {String} FilePath The path of the file to be sent
*/
function PTK_SendFile(FilePath){
printparamsJsonArray.push({"PTK_SendFile" : FilePath});
}
	
	 /**
	* @description send command data to printer
	* @param {String} data instruction data
	* @param {Number} datalen command data length
	*/
function PTK_SendCmd(data,datalen){
	printparamsJsonArray.push({"PTK_SendCmd":data+","+datalen});
}


/**
* @description send data to printer
* @param {Number} charset data format; value 0 or 1 0-GBK 1-UTF-8
* @param {String} data data content
*/
function PTK_SendString(charset,data){
	printparamsJsonArray.push({"PTK_SendString":charset+","+data});
}


/**
* @description is used to get the USB port information of all current printers connected by USB; only supports reading by USB, you need to connect the USB cable and turn on the printer before reading. This function can be called without opening a set of ports
* @param {String} USBInfo port information name
* @param {Number} infoSize The space size of USBInfo
*/
function PTK_GetAllPrinterUSBInfo(USBInfo,infoSize){
	printparamsJsonArray.push({"PTK_GetAllPrinterUSBInfo":USBInfo+","+infoSize});
}


//*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^ -^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
 
 /**
 * @@description printer settings
 * =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
 */

/**
 * @description command the printer to print a self-test page
 */
function PTK_PrintConfiguration(){
printparamsJsonArray.push({"PTK_PrintConfiguration":""});
}

/**
* @description Commands the printer to perform label registration calibration
*/
function PTK_MediaDetect(){
printparamsJsonArray.push({"PTK_MediaDetect":""});
}

/**
* @description instructs the printer to feed the paper with a fixed length; ◆ Not all models have this function
* @param {Number} feedLen advance length, the parameter type is a positive integer
*/
function PTK_UserFeed(feedLen){
printparamsJsonArray.push({"PTK_UserFeed" : feedLen});
}

/**
* @description command the printer to return the paper to a fixed length; ◆ Not all models have this function
* @param {Number} feedLen : the length of the back, the parameter type is a positive integer
*/
function PTK_UserBackFeed(feedLen){
printparamsJsonArray.push({"PTK_UserBackFeed" : feedLen});
}

/**
* @description Command the printer to open the FLASH storage, call the storage-related API functions, and the data will be stored in the printer FLASH. ◆ Successfully stored data will not be lost after power failure
*/
function PTK_EnableFLASH(){
printparamsJsonArray.push({"PTK_EnableFLASH":""});
}

/**
* @description Turn off data storage to printer FLASH
*/
function PTK_DisableFLASH(){
printparamsJsonArray.push({"PTK_DisableFLASH":""});
}

/**
* @description command the printer to print a blank label
*/
function PTK_FeedMedia(){
printparamsJsonArray.push({"PTK_FeedMedia":""});
}

/**
* @description Set the cutting frequency. ◆ Only supports printers with cutter
* @param {Number} page cut frequency . parameter type is integer
*/
function PTK_CutPage(page){
printparamsJsonArray.push({"PTK_CutPage" : page});
}

/**
* @description Set the paper cutting frequency; invalid when power off. ◆ Only supports printers with cutter
* @param {Number} page cut frequency . parameter type is integer
*/
function PTK_CutPageEx(page){
printparamsJsonArray.push({"PTK_CutPageEx" : page});
}

/**
* @description sets the coordinate origin for printing; deprecated
* @param {Number} px horizontal axis coordinate
* @param {Number} py vertical axis coordinate
*/
function PTK_SetCoordinateOrigin(px,py){
printparamsJsonArray.push({"PTK_SetCoordinateOrigin":px+","+py});
}



function PTK_GetUtilityInfo(infoNum,data,dataSize){
printparamsJsonArray.push({"PTK_GetUtilityInfo":infoNum+","+data+","+dataSize});
}

function PTK_GetAllPrinterInfo(infoNum,fileflag,data,dataSize){
printparamsJsonArray.push({"PTK_GetAllPrinterInfo":infoNum+","+fileflag+","+data+","+dataSize});
}


/**
* @description Get printer status in real time through USB interrupt, see Development Manual - Printer Status Code Analysis
* @param {String} status custom printer status name
*/
function PTK_ErrorReport_USBInterrupt(status){
printparamsJsonArray.push({"PTK_ErrorReport_USBInterrupt" : status});
}


function PTK_GetPrinterName(PrinterName){
printparamsJsonArray.push({"PTK_GetPrinterName" : PrinterName});
}

function PTK_GetPrinterDPI(dpi){
printparamsJsonArray.push({"PTK_GetPrinterDPI" : dpi});
}

function PTK_GetPrinterKey_USB(printerKey){
printparamsJsonArray.push({"PTK_GetPrinterKey_USB" : printerKey});
}

//*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^ -^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=


/**
* @@description tag settings
* =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
*/

/**
* @description Clears the buffered content in the printer; it is recommended to use it before printing the content to prevent the printer from having residual data and causing printing to fail. It cannot be used in the process of saving the form, otherwise the form creation will fail
*/
function PTK_ClearBuffer(){
printparamsJsonArray.push({"PTK_ClearBuffer":""});
}

/**
* @description Set the current label printing speed; the maximum printing speed of different models is different, if the setting value exceeds the maximum printing speed of the model, it will not take effect
* @param {Number} px print speed. For the value, please refer to the development manual
*/
function PTK_SetPrintSpeed(px){
printparamsJsonArray.push({"PTK_SetPrintSpeed":px});
}

/**
* @description set the current label printing direction
* @param {String} direct is B or T; T -> print from the top B -> print from the bottom
*/
function PTK_SetDirection(direct){
printparamsJsonArray.push({"PTK_SetDirection":direct});
}


/**
* @description set the current label printing blackness
* @param {Number} id Label printing blackness. Value: a positive integer from 0 to 20, the larger the value, the darker the print blackness.
*/
function PTK_SetDarkness(id){
printparamsJsonArray.push({"PTK_SetDarkness":id});
}

/**
* @description Set the height of the current label, the height of the positioning gap\black mark\perforation, and the positioning offset. For details, please refer to the development manual
* @param {Number} lheight The height of the label, in dots. Value: positive integer from 0 to 65535
* @param {Number} gapH The height of the positioning gap\black mark\perforation between labels, in dots. Value: a positive integer from 0 to 65535. When gap=0, set the label to continuous paper; when the actual label is not continuous paper and the gap is set to 0, the print content will be offset.
* @param {Number} gapOffset Label gap \ black line \ perforation positioning offset value, in dots (dots), the parameter type is a positive integer
* @param {Boolean} bFlag Whether the positioning offset value (gapOffset) is valid; true - valid, false - invalid
*/
function PTK_SetLabelHeight(lheight, gapH, gapOffset, bFlag){
printparamsJsonArray.push({"PTK_SetLabelHeight":lheight+","+gapH+","+gapOffset+","+bFlag});
}
	 
	 
	 /**
	  * @description 设置当前标签的宽度
	  * @param {Number} lwidth 标签的宽度，以点(dots)为单位。取值：0 – 65535的正整数
	  */
	 function PTK_SetLabelWidth(lwidth){
	 	printparamsJsonArray.push({"PTK_SetLabelWidth":lwidth});
	 }
	 
	 /**
	  * @description 	命令打印机开始打印标签内容
	  * @param {Number} Number 打印标签的数量。取值：1 – 65535的正整数
	  * @param {Number} cpnumber 每张标签的复制份数。取值：1 – 65535的正整数
	  */
	 function PTK_PrintLabel(Number,cpnumber){
	 	printparamsJsonArray.push({"PTK_PrintLabel":Number+","+cpnumber});
	 } 
	 
	 
	 /**
	  * @description 	命令打印机开始打印一张标签内容，打印完后读取当前打印机状态.仅支持固件版本为7.60以上打印机;不能和PTK_PrintLabe	l一起使用
	  * @param {String} data 自定义状态码名称
	  * @param {Number} dataSize 状态码的数据长度，参数类型为正整数；最小为6
	  */
	 function PTK_PrintLabelFeedback(data,dataSize){
	  	printparamsJsonArray.push({"PTK_PrintLabelFeedback":data+","+dataSize});
	 }
   
	 //*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
	 
	 
	 
	 /**
	 * @@description print_text
	 * =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= 
	 */	
	
	/**
* @description edit a line of text with the printer's built-in font;
* @param {Number} px The horizontal coordinate of the text, in dots, the parameter type is a positive integer; if the value of px exceeds the width of the label, the text content will be cut off
* @param {Number} py Text ordinate, in dots, the parameter type is a positive integer; the text content will be cut off if the value of y exceeds the height of the label
* @param {Number} pdirec text direction, parameter value and description are as follows: 0 - normal; 1 - rotate 90; 2 - rotate 180; 3 - rotate 270°
* @param {String} pFont font name. Value: 1 - 6 positive integers or A - Z; 1 - 5: the printer has 5 built-in Western dot matrix fonts; 6: the printer has built-in boldface; A-Z: the name of the font downloaded by the user, the printer does not have built-in A-Z fonts
* @param {Number} pHorizontal Horizontal magnification factor (dot) or font width (vector). The parameter type is a positive integer
* @param {Number} pVertical vertical magnification factor (dot) or font height (vector). The parameter type is a positive integer
* @param {String} ptext text style, parameter value and description are as follows: N - black text on white background, R - white text on black background
* @param {String} pstr text data
*/
function PTK_DrawText(px,py,pdirec,pFont,pHorizontal,pVertical,ptext,pstr){
printparamsJsonArray.push({"PTK_DrawText":px+","+py+","+pdirec+","+pFont+","+pHorizontal+","+pVertical+","+ptext
+","+pstr});
}

/**
* @param {Number} px The horizontal coordinate of the text, in dots, the parameter type is a positive integer; if the value of px exceeds the width of the label, the text content will be cut off
* @param {Number} py Text ordinate, in dots, the parameter type is a positive integer; the text content will be cut off if the value of y exceeds the height of the label
* @param {Number} pdirec text direction, parameter value and description are as follows: 0 - normal; 1 - rotate 90; 2 - rotate 180; 3 - rotate 270°
* @param {String} pFont font name. Value: 1 - 6 positive integers or A - Z; 1 - 5: the printer has 5 built-in Western dot matrix fonts; 6: the printer has built-in boldface; A-Z: the name of the font downloaded by the user, the printer does not have built-in A-Z fonts
* @param {Number} pHorizontal Horizontal magnification factor (dot) or font width (vector). The parameter type is a positive integer
* @param {Number} pVertical vertical magnification factor (dot) or font height (vector). The parameter type is a positive integer
* @param {Number} ptext text style, parameter values ​​and descriptions are as follows: N - black text on a white background, R - white text on a black background
* @param {String} pstr text data
* @param {Boolean} varible Whether the current string contains variables
*/
function PTK_DrawTextEx(px,py,pdirec,pFont,pHorizontal,pVertical,ptext,pstr,varible){
printparamsJsonArray.push({"PTK_DrawTextEx":px+","+py+","+pdirec+","+pFont+","+pHorizontal+","+pVertical+","+ptext+" ,"+pstr+","+varible });
}

/**
* @description call the windows font library to print a line of TrueType fonts; it is recommended to use PTK_DrawText_TrueType
* @param {Number} x The horizontal coordinate of the text, in dots, the parameter type is a positive integer; if the value of x exceeds the width of the label, the text content will be truncated
* @param {Number} y vertical coordinate of text, in dots, the parameter type is a positive integer; if the value of y exceeds the height of the label, the text content will be truncated
* @param {Number} FHeight character height, in dots (dots), the parameter type is a positive integer
* @param {Number} FWidth Character width, in dots (dots), the parameter type is a positive integer; to print a normal scale font, this value needs to be set to 0
* @param {String} FType font type name, for example: Song Dynasty
* @param {Number} Fspin Text direction. Value: a positive integer from 1 to 8. The parameter values ​​and descriptions are as follows: 1—left 0°, 2—left 90°, 3—left 180°, 4—left 270° 5—center 0°, 6—center 90° , 7—180° in the center, 8—270° in the center
* @param {Number} FWeight text weight, parameter value and description are as follows: 400 - standard, 100 - very thin, 200 - very thin, 300 - thin, 500 - medium, 600 - half thick, 700 - thick, 800 - special Coarse, 900 - Bold
* @param {Number} FItalic italic setting, parameter value and description are as follows: 0 - normal, 1 - italic
* @param {Number} FUnline underline setting, parameter value and description are as follows: 0 - normal, 1 - add underline to the text
* @param {Number} FStrikeOut strikethrough setting, parameter value and description are as follows: 0 - normal, 1 - add strikethrough for text
* @param {String} id_name custom text name
* @param {String} data text data
*/
function PTK_DrawTextTrueTypeW(x,y,FHeight,FWidth,FType,Fspin,FWeight,FItalic,FUnline,FStrikeOut,id_name,data){
printparamsJsonArray.push({"PTK_DrawTextTrueTypeW":x+","+y+","+FHeight+","+FWidth+","+FType+","+Fspin+","+FWeight+ ","+FItalic+","+FUnline+ ","+FStrikeOut+","+id_name+","+data});
}


/**
* @description calls the font library of windows and prints a line of TrueType fonts;
* @param {Number} x The horizontal coordinate of the text, in dots, the parameter type is a positive integer; if the value of x exceeds the width of the label, the text content will be truncated
* @param {Number} y vertical coordinate of text, in dots, the parameter type is a positive integer; if the value of y exceeds the height of the label, the text content will be truncated
* @param {Number} FHeight character height, in dots (dots), the parameter type is a positive integer
* @param {Number} FWidth Character width, in dots (dots), the parameter type is a positive integer; to print a normal scale font, this value needs to be set to 0
* @param {String} FType font type name, for example: Song Dynasty
* @param {Number} Fspin Text direction. Value: a positive integer from 1 to 8. The parameter values ​​and descriptions are as follows: 1—left 0°, 2—left 90°, 3—left 180°, 4—left 270° 5—center 0°, 6—center 90° , 7—180° in the center, 8—270° in the center
* @param {Number} FWeight text weight, parameter value and description are as follows: 400 - standard, 100 - very thin, 200 - very thin, 300 - thin, 500 - medium, 600 - half thick, 700 - thick, 800 - special Coarse, 900 - Bold
* @param {Number} FItalic italic setting, parameter value and description are as follows: 0 - normal, 1 - italic
* @param {Number} FUnline underline setting, parameter value and description are as follows: 0 - normal, 1 - add underline to the text
* @param {Number} FStrikeOut strikethrough setting, parameter value and description are as follows: 0 - normal, 1 - add strikethrough for text
* @param {String} data text data
*/
function PTK_DrawText_TrueType(x,y,FHeight,FWidth,FType,Fspin,FWeight,FItalic,FUnline,FStrikeOut,data){
printparamsJsonArray.push({"PTK_DrawText_TrueType":x+","+y+","+FHeight+","+FWidth+","+FType+","+Fspin+","+FWeight+ ","+FItalic+","+FUnline+ ","+FStrikeOut+","+data});
}

function PTK_DrawText_TrueType_AutoFeedLine(x,y,FHeight,FWidth,FType,Fspin,FWeight,FItalic,FUnline,FStrikeOut, lineMaxWidth,lineMaxNum, lineGapH,middleSwitch,codeFormat,data){
printparamsJsonArray.push({"PTK_DrawText_TrueType_AutoFeedLine":x+","+y+","+FHeight+","+FWidth+","+FType+","+Fspin +","+FWeight+ ","+FItalic+","+ FUnline+","+FStrikeOut+","+lineMaxWidth+","+lineMaxNum+","+ lineGapH+","+middleSwitch+","+codeFormat+","+data});
}
	
/**
* @description call the Windows font library to edit multi-line text; support automatic line wrapping, vertical printing
* @param {Number} x The horizontal coordinate of the text, in dots, the parameter type is a positive integer; if the value of x exceeds the width of the label, the text content will be truncated
* @param {Number} y vertical coordinate of text, in dots, the parameter type is a positive integer; if the value of y exceeds the height of the label, the text content will be truncated
* @param {Number} FHeight character height, in dots (dots), the parameter type is a positive integer
* @param {Number} FWidth Character width, in dots (dots), the parameter type is a positive integer; to print a normal scale font, this value needs to be set to 0
* @param {String} FType font type name, for example: Song Dynasty
* @param {Number} Fspin Text direction. Values: positive integers from 1 to 8, parameter values ​​and descriptions are as follows: 1—horizontal 0°, 2—horizontal 90°, 3—horizontal 180°, 4—horizontal 270°; 5—vertical 0°, 6—vertical 90° °, 7—vertical 180°, 8—vertical 270°
* @param {Number} FWeight text weight, parameter value and description are as follows: 400 - standard, 100 - very thin, 200 - very thin, 300 - thin, 500 - medium, 600 - half thick, 700 - thick, 800 - special Coarse, 900 - Bold
* @param {Number} FItalic italic setting, parameter value and description are as follows: 0 - normal, 1 - italic
* @param {Number} FUnline underline setting, parameter value and description are as follows: 0 - normal, 1 - add underline to the text
* @param {Number} FStrikeOut strikethrough setting, parameter value and description are as follows: 0 - normal, 1 - add strikethrough for text
* @param {Number} lineMaxWidth Set the maximum number of characters in a single line. If the number of characters exceeds this number, the line will be automatically wrapped. The parameter type is a positive integer. When Fspin is in the horizontal direction, 1 Chinese character is 2 characters; when Fspin is in the vertical direction, 1 Chinese character is 1 character; when the value is 0, there is no limit
* @param {Number} lineMaxNum The maximum number of newlines, the parameter type is a positive integer; when the value is 0, there is no limit
* @param {Number} lineGapH line gap, unit dots, parameter type is a positive integer; when the value is 0, there is no limit
* @param {Number} middleSwitch Text center selection, parameter values ​​and descriptions are as follows: 0 - not center, 1 - horizontal center, 2 - vertical center, 3 - horizontal and vertical center
* @param {String} data text data
*/
function PTK_DrawText_TrueTypeEx(x,y,FHeight,FWidth,FType,Fspin,FWeight,FItalic,FUnline,FStrikeOut, lineMaxWidth,lineMaxNum, lineGapH,middleSwitch,data){
printparamsJsonArray.push({"PTK_DrawText_TrueTypeEx":x+","+y+","+FHeight+","+FWidth+","+FType+","+Fspin +","+FWeight+ ","+FItalic+","+ FUnline+","+FStrikeOut+","+lineMaxWidth+","+lineMaxNum+","+ lineGapH+","+middleSwitch+","+data});
}

//*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^ -^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=


/**
* @@description print image
* =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
*/

/**
* @description prints a list of graphic names that have been stored in the printer's RAM or FLASH memory
*/
function PTK_PcxGraphicsList(){
printparamsJsonArray.push({"PTK_PcxGraphicsList":""});
}

/**
* @description delete the picture stored by the printer
* @param {String} pid The graphic name stored inside the printer, the maximum length is 16 characters; when pcxname=*, delete all graphics in the printer
*/
function PTK_PcxGraphicsDel(pid){
printparamsJsonArray.push({"PTK_PcxGraphicsDel":pid});
} // delete one or all graphics stored in printer RAM or FLASH memory

/**
* @description print the image saved in the printer
* @param {Number} px X coordinate, in dots, the parameter type is a positive integer
* @param {Number} py y coordinate, in dots, the parameter type is a positive integer
* @param {String} gname The graphic name stored inside the printer, the maximum length is 16 characters
*/
function PTK_DrawPcxGraphics(px,py,gname){
printparamsJsonArray.push({"PTK_DrawPcxGraphics":px+","+py+","+gname});
}

/**
* @description print graphics via graphics path
* @param {Number} x X coordinate, in dots, the parameter type is a positive integer
* @param {Number} y y coordinate, in dots, the parameter type is a positive integer
* @param {String} GraphicsName Graphics name stored inside the printer, the maximum length is 16 characters
* @param {String} filePath graphic file path (support network path). Currently supported formats: bmp, jpg, png, tif, ico, pcx
* @param {Number} ratio scaling factor, the parameter type is floating point; width and height take effect only when the parameter is 0
* @param {Number} width specifies the width of the graphic (unit: dot), the parameter type is a positive integer. When the parameter is 0, the width of the graphic is the original width
* @param {Number} height specifies the height of the graphic (unit: dot), the parameter type is a positive integer. When the parameter is 0, the width of the graphic is the original height
* @param {Number} iDire rotation angle. Value: positive integer from 0 to 5, parameter values ​​and description are as follows: 0 - 0°, 1 - 90°, 2 - 180°, 3 - 270°, 4 - vertical mirror flip, 5 - horizontal mirror flip
*/
function PTK_AnyGraphicsPrint( x, y, GraphicsName, filePath, ratio, width, height, iDire){
	printparamsJsonArray.push({"PTK_AnyGraphicsPrint":x+","+y+","+GraphicsName+","+filePath+","+ratio+","+width+ ","+height+","+iDire});
}
	 
/**
* @description store a PCX format graphic to the printer
* @param {String} pcxname The name of the custom graphic, the maximum length is 16 characters; after the graphic is stored in the printer, the user can use this name in PTK_DrawPcxGraphics() to read the graphic and print it
* @param {String} pcxpath PCX graphics file path in PC memory
*/
function PTK_PcxGraphicsDownload(pcxname,pcxpath){
printparamsJsonArray.push({"PTK_PcxGraphicsDownload":pcxname+","+pcxpath});
} // Store a graphic in PCX format to the printer

/**
* @description print the graphics stored on the printer
* @param {Number} px X coordinate, in dots, the parameter type is a positive integer
* @param {Number} py y coordinate, in dots, the parameter type is a positive integer
* @param {String} filename the graphic name stored in the printer
*/
function PTK_PrintPCX(px,py,filename){
	printparamsJsonArray.push({"PTK_PrintPCX":px+","+py+","+filename});
}// The function is to print a function is to print a graphic in PCXPCXPCX format.



//*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^ -^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=



/**
* @@description print lines
* =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
*/

/**
* @description draw a rectangle (hollow) on the label
* @param {Number} px The X coordinate of the starting point of the rectangle, in dots, the parameter type is a positive integer
* @param {Number} py The y coordinate of the starting point of the rectangle, in dots, the parameter type is a positive integer
* @param {Number} thickness The thickness of the rectangle border, in dots, the parameter type is a positive integer
* @param {Number} pEx The X coordinate of the end point of the rectangle, in dots, the parameter type is a positive integer
* @param {Number} pEy The y-coordinate of the end point of the rectangle, in dots, the parameter type is a positive integer
*/
function PTK_DrawRectangle(px,py,thickness,pEx,pEy){
	printparamsJsonArray.push({"PTK_DrawRectangle":px+","+py+","+thickness+","+pEx+","+pEy});
}

/**
* @description draw a straight line, intersect it for XOR processing
* @param {Number} px The X coordinate of the starting point of the line, in dots, the parameter type is a positive integer
* @param {Number} py The y-coordinate of the starting point of the line, in dots, the parameter type is a positive integer
* @param {Number} length The length of the line, in dots, the parameter type is a positive integer
* @param {Number} height The vertical height of the line, in dots, the parameter type is a positive integer
*/
function PTK_DrawLineXor(px,py,length,heigth){
	printparamsJsonArray.push({"PTK_DrawLineXor":px+","+py+","+length+","+heigth});
}

/**
* @description draw a line, intersect it or process it
* @param {Number} px The X coordinate of the starting point of the line, in dots, the parameter type is a positive integer
* @param {Number} py The y-coordinate of the starting point of the line, in dots, the parameter type is a positive integer
* @param {Number} length The length of the line, in dots, the parameter type is a positive integer
* @param {Number} height The vertical height of the line, in dots, the parameter type is a positive integer
*/
function PTK_DrawLineOr(px,py,length,heigth){
	printparamsJsonArray.push({"PTK_DrawLineOr":px+","+py+","+length+","+heigth});
}

/**
* @description draw a slash if intersecting do or process
* @param {Number} px The X coordinate of the starting point of the slash, in dots, the parameter type is a positive integer
* @param {Number} py The y-coordinate of the starting point of the slash, in dots, the parameter type is a positive integer
* @param {Number} thickness The thickness of the slash border, in dots, the parameter type is a positive integer
* @param {Number} pEx The X coordinate of the end point of the slash, in dots, the parameter type is a positive integer
* @param {Number} pEy The y-coordinate of the end point of the slash, in dots, the parameter type is a positive integer
*/
function PTK_DrawDiagonal(px,py,thickness,pEx,pEy){
	printparamsJsonArray.push({"PTK_DrawDiagonal":px+","+py+","+thickness+","+pEx+","+pEy});
}


/**
* @description draw a white line
* @param {Number} px The X coordinate of the starting point of the white line, in dots, the parameter type is a positive integer
* @param {Number} py The y-coordinate of the starting point of the white line, in dots, the parameter type is a positive integer
* @param {Number} length The length of the white line, in dots, the parameter type is a positive integer
* @param {Number} height The vertical height of the white line, in dots, the parameter type is a positive integer
*/
function PTK_DrawWhiteLine(px,py,length,heigth){
	printparamsJsonArray.push({"PTK_DrawWhiteLine":px+","+py+","+length+","+heigth});
}


//*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^ -^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=



/**
* @@description print QR code
* =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
*/

/**
* @description edit QR code; use PTK_DrawBar2D_QREx for compatibility with all printer firmware versions
* @param {Number} x QR code X coordinate, in dots, the parameter type is a positive integer
* @param {Number} y QR code y coordinate, in dots, the parameter type is a positive integer
* @param {Number} w Width, in dots, the parameter type is a positive integer. This parameter is temporarily invalid, please enter 0
* @param {Number} v QR code version number. Value: a positive integer from 0 to 40. The parameter values ​​and descriptions are as follows: Version 1 is a 21*21 matrix. Each time a version number is added, the size of the matrix increases by 4 modules. The version number and the corresponding matrix are as follows: 0: automatic matching (the size of the QR will change with the data); 1: 21* 21; 2: 25* 25...40: 177* 177; QR's side length L The relationship between (in dots) and version number: L=r*(21+4*(v-1))
* @param {Number} o Rotation direction. Values: positive integers from 0 to 3, parameter values ​​and descriptions are as follows: 0 - 0°, 1 - 90°, 2 - 180°, 3 - 270°
* @param {Number} r magnification. Value: positive integer from 0 to 99
* @param {Number} m reserved parameter, please enter 0
* @param {Number} g QR code error correction level. Value: positive integer from 0 to 3, parameter values ​​and descriptions are as follows: 0 - L level, 1 - M level, 2 - Q1 level, 3 - H1 level
* @param {Number} s QR code mask graphic. The value ranges from 0 to 8. The parameter values ​​and descriptions are as follows: 0 - Mask pattern 000 1 - Mask pattern 001 2 - Mask pattern 010 3 - Mask pattern 011 4 - Mask pattern 100 5 - Mask pattern 101 6 - Mask Pattern 110 7 - Mask Pattern 111 8 - Automatic Mask Pattern Selection
* @param {String} QRData QR code content data
*/
function PTK_DrawBar2D_QR(x,y,w,v,o,r,m,g,s,QRData){
	printparamsJsonArray.push({"PTK_DrawBar2D_QR":x+","+y+","+w+","+v+","+o+","+r+","+m+","+g+","+s+ ","+QRData});
}
	
	
/**
* @description edit QR code
* @param {Number} x QR code X coordinate, in dots, the parameter type is a positive integer
* @param {Number} y QR code y coordinate, in dots, the parameter type is a positive integer
* @param {Number} o Rotation direction. Values: positive integers from 0 to 3, parameter values ​​and descriptions are as follows: 0 - 0°, 1 - 90°, 2 - 180°, 3 - 270°
* @param {Number} r magnification. Value: positive integer from 0 to 99
* @param {Number} g QR code error correction level. Value: positive integer from 0 to 3, parameter values ​​and descriptions are as follows: 0 - L level, 1 - M level, 2 - Q1 level, 3 - H1 level
* @param {Number} sQR code mask graphic. The value ranges from 0 to 8. The parameter values ​​and descriptions are as follows: 0 - Mask pattern 000 1 - Mask pattern 001 2 - Mask pattern 010 3 - Mask pattern 011 4 - Mask pattern 100 5 - Mask pattern 101 6 - Mask Pattern 110 7 - Mask Pattern 111 8 - Automatic Mask Pattern Selection
* @param {Number} v QR code version number. Value: a positive integer from 0 to 40. The parameter values ​​and descriptions are as follows: Version 1 is a 21*21 matrix. Each time a version number is added, the size of the matrix increases by 4 modules. The version number and the corresponding matrix are as follows: 0: automatic matching (the size of the QR will change with the data); 1: 21* 21; 2: 25* 25...40: 177* 177; QR's side length L The relationship between (in dots) and version number: L=r*(21+4*(v-1))
* @param {String} QRName Custom QR code name, the maximum length is 16 characters
* @param {String} QRData QR code content data
*/
function PTK_DrawBar2D_QREx(x,y,o,r,g,s,v,QRName,QRData){
	printparamsJsonArray.push({"PTK_DrawBar2D_QREx":x+","+y+","+o+","+r+","+g+","+s+","+v+","+QRName+","+QRData });
}

/**
* @description edit Chinese letter code
* @param {Number} x Hanxin code X coordinate, in dots, the parameter type is a positive integer
* @param {Number} y The y-coordinate of the Hanxin code, in dots, the parameter type is a positive integer
* @param {Number} w width, in dots; this parameter is temporarily invalid, please enter 0
* @param {Number} v Height, in dots; this parameter is temporarily invalid, please enter 0
* @param {Number} o Rotation direction. Values: positive integers from 0 to 3. The parameter values ​​and descriptions are as follows: 0 - 0°, 1: 90°, 2 - 180°, 3 - 270°
* @param {Number} r magnification. Value: positive integer from 0 to 30
* @param {Number} m Chinese letter coding mode, value: positive integer from 0 to 6, parameter value and description are as follows: 0 - digital mode 1 - TEXT mode 2 - binary mode 3 - common Chinese characters 1 area mode code 4 - Common Chinese characters 2-area mode code 5 - GB 18030 double-byte area mode 6 - GB 18030 four-byte mode code
* @param {Number} g Hanxin code error correction level. Value: positive integer from 0 to 3, parameter values ​​and description are as follows: 0 - L1 level, 1 - L2 level, 2 - L3 level, 3 - L4 level
* @param {Number} s Chinese character mask pattern. A positive integer valued from 0 to 3. The parameter values ​​and descriptions are as follows: 0 - mask pattern 00 1 - mask pattern 01 2 - mask pattern 10 3 - mask pattern 11
* @param {String} HXData Hanxin code content data
*/
function PTK_DrawBar2D_HANXIN(x,y,w,v,o,r,m,g,s,HXData){
	printparamsJsonArray.push({"PTK_DrawBar2D_HANXIN":x+","+y+","+w+","+v+","+o+","+r+","+m+","+g+","+s+ ","+HXData});
}


/**
* @description Edit PDF417 code. For compatibility with all printer firmware versions, please use PTK_DrawBar2D_Pdf417Ex
* @param {Number} x Pdf417 code X coordinate, in dots, the parameter type is a positive integer
* @param {Number} y Pdf417 code y coordinate, in dots, the parameter type is a positive integer
* @param {Number} w width, in dots. This parameter is temporarily invalid, please enter 0
* @param {Number} v Height, in dots. This parameter is temporarily invalid, please enter 0
* @param {Number} s Error correction level. Value: positive integer from 0 to 8
* @param {Number} c Data compression level. The value is 0 or 1. This parameter is temporarily invalid, please enter 0
* @param {Number} X Module width, in dots. Value: positive integer from 2 to 9
* @param {Number} Y module height, in dots. Value: positive integer from 4 to 99
* @param {Number} r Maximum number of lines. Value: positive integer from 3 to 90
* @param {Number} l Maximum number of columns. Value: positive integer from 1 to 30
* @param {Number} t interception flag. Value: 0 or 1, the parameter value and description are as follows. 0 - not intercept, 1 - intercept
* @param {Number} o Rotation direction. Value: a positive integer from 0 to 3. The parameter values ​​and descriptions are as follows: 0 - 0°, 1 - 90°, 2 - 180°, 3 - 270°
* @param {String} pdf417Data DF417 code content data. When the parameters X, Y, r, l are fixed and the data amount does not exceed the maximum data amount that r and l can hold, the size of the pdf417 print is fixed. The formula for calculating the width and height of PDF417 yards is as follows: Width: (l*17+69)*X Height: r*Y
*/
function PTK_DrawBar2D_Pdf417(x,y,w,v,s,c,X,Y,r,l,t,o,pdf417Data){
	printparamsJsonArray.push({"PTK_DrawBar2D_Pdf417":x+","+y+","+w+","+v+","+s+","+c+","+X+","+Y+","+r+ ","+l+","+t+ ","+o+","+pdf417Data});
}

/**
* @description edit PDF417 code
* @param {Number} x Pdf417 code X coordinate, in dots, the parameter type is a positive integer
* @param {Number} y Pdf417 code y coordinate, in dots, the parameter type is a positive integer
* @param {Number} w width, in dots. This parameter is temporarily invalid, please enter 0
* @param {Number} v Height, in dots. This parameter is temporarily invalid, please enter 0
* @param {Number} s Error correction level. Value: positive integer from 0 to 8
* @param {Number} c Data compression level. The value is 0 or 1. This parameter is temporarily invalid, please enter 0
* @param {Number} px module width, in dots. Value: positive integer from 2 to 9
* @param {Number} py module height, in dots. Value: positive integer from 4 to 99
* @param {Number} r Maximum number of lines. Value: positive integer from 3 to 90
* @param {Number} l Maximum number of columns. Value: positive integer from 1 to 30
* @param {Number} t interception flag. Value: 0 or 1, the parameter value and description are as follows. 0 - not intercept, 1 - intercept
* @param {Number} o Rotation direction. Value: a positive integer from 0 to 3. The parameter values ​​and descriptions are as follows: 0 - 0°, 1 - 90°, 2 - 180°, 3 - 270°
* @param {String} pdf417Data DF417 code content data. When the parameters X, Y, r, l are fixed and the data amount does not exceed the maximum data amount that r and l can hold, the size of the pdf417 print is fixed. The formula for calculating the width and height of PDF417 yards is as follows: Width: (l*17+69)*X Height: r*Y
*/
function PTK_DrawBar2D_Pdf417Ex(x,y,w,v,s,c,px,py,r,l,t,o,pdf417Data){
	printparamsJsonArray.push({"PTK_DrawBar2D_Pdf417Ex":x+","+y+","+w+","+v+","+s+","+c+","+px+","+py+","+r+ ","+l+","+t+ ","+o+","+pdf417Data});
}

/**
* @description edit MaxiCode
* @param {Number} x MaxiCode X coordinate, in dots, the parameter type is a positive integer
* @param {Number} y MaxiCode y coordinate, in dots, the parameter type is a positive integer
* @param {Number} m Symbology mode. Value: positive integer from 2 to 4, parameter value and description are as follows: 2 - structured carrier information 3 - structured carrier information 4 - standard symbol
* @param {Number} whether u is in UPS format. Value: 0 or 1, the parameter value and description are as follows: 1 - UPS format data 0 - non-UPS format data
* @param {String} mcData MaxiCode content data
*/
function PTK_DrawBar2D_MaxiCode(x,y,m,u,mcData){
	printparamsJsonArray.push({"PTK_DrawBar2D_MaxiCode":x+","+y+","+m+","+u+","+mcData});
}
	
/**
* @description edit Data Matrix code
* @param {Number} x MaxiCode X coordinate, in dots, the parameter type is a positive integer
* @param {Number} y MaxiCode y coordinate, in dots, the parameter type is a positive integer
* @param {Number} w width, in dots. This parameter is temporarily invalid, please enter 0
* @param {Number} h height, in dots. This parameter is temporarily invalid, please enter 0
* @param {Number} o Rotation direction. Values: positive integers from 0 - 3. 0 - 0°, 1 - 90°, 2 - 180°, 3 - 270°
* @param {Number} m magnification, the parameter type is a positive integer
* @param {String} dmData: Data Matrix code data content
*/
function PTK_DrawBar2D_DATAMATRIX(x,y,w,h,o,m,dmData){
printparamsJsonArray.push({"PTK_DrawBar2D_DATAMATRIX":x+","+y+","+w+","+h+","+o+","+m+","+dmData});
}

//*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^ -^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=



/**
* @@description print one-dimensional code
* =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
*/

/**
* @description edit 1D barcode
* @param {Number} px One-dimensional code X coordinate, in dots, the parameter type is a positive integer
* @param {Number} py One-dimensional code y-coordinate, in dots, the parameter type is a positive integer
* @param {Number} pdirec rotation direction. Value: a positive integer from 0 to 3. The parameter values ​​and descriptions are as follows: 0 - 0°, 1 - 90°, 2 - 180°, 3 - 270°
* @param {String} pCode barcode type. Please refer to the development manual for the value
* @param {Number} pHorizontal Set the width of the narrow unit in the barcode, in dots, the parameter type is a positive integer
* @param {Number} pVertical Set the width of the wide unit in the barcode, in dots, the parameter type is a positive integer
* @param {Number} pbright Set the height of the barcode, in dots, the parameter type is a positive integer
* @param {String} humanReadable for human identifiers. Value: N or B, the parameter value and description are as follows: N - do not display the identification identifier B - display the worker identifier
* @param {String} Data One-dimensional code content data
*/
function PTK_DrawBarcode(px,py,pdirec,pCode,pHorizontal,pVertical,pbright,humanReadable,Data){
printparamsJsonArray.push({"PTK_DrawBarcode":px+","+py+","+pdirec+","+pCode+","+pHorizontal+","+pVertical+ ","+pbright+","+humanReadable+","+Data });
}


function PTK_DrawBarcodeEx(px,py,pdirec,pCode,NarrowWidth,pHorizontal,pVertical,pbright,ptext,pstr,Variable){
printparamsJsonArray.push({"PTK_DrawBarcodeEx":px+","+py+","+pdirec+","+pCode+","+NarrowWidth+","+pHorizontal+ ","+pVertical+","+pbright+","+ptext+ ","+pstr+","+Variable});
}

//*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^ -^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=


/**
* @@description print form and related
* =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^ = =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
*/

/**
* @description Description: Get the form, font or graphic name stored in FLASH. Only FLASH can be obtained, not RAM. Only supports USB read
* @param {String} tempName custom get data name
* @param {Number} listBuffSize data length
* @param {Number} TempType The name list type to get; 0: Form 1: Font 2: Graphic
*/
function PTK_GetStorageList(tempName,listBuffSize,TempType){
printparamsJsonArray.push({"PTK_GetStorageList":tempName+","+listBuffSize+","+TempType});
}


     /**
* @description prints a list of form names that have been stored in the printer's RAM or FLASH memory
*/
function PTK_FormList(){
printparamsJsonArray.push({"PTK_FormList":""});
}

/**
* @description deletes the form stored in the printer.
* @param {String} pid The name of the form stored in the printer, no more than 16 bytes
*/
function PTK_FormDel(pid){
printparamsJsonArray.push({"PTK_FormDel":pid});
}

/**
* @description tells the printer to start saving a form to the printer
* @param {String} pid Name the form name stored in the printer, no more than 16 bytes
*/
function PTK_FormDownload(pid){
printparamsJsonArray.push({"PTK_FormDownload":pid});
}


/**
* @description informs the printer about the end of form storage
*/
function PTK_FormEnd(){
	printparamsJsonArray.push({"PTK_FormEnd":""});
}
	
	
	 /**
	  * @description  运行一个表单，相当于将表单内容中的API函数全部执行一次
	  * @param {String} pid 印机中存储的表单名称，不超过16字节
	  */
	 function PTK_ExecForm(pid){
		printparamsJsonArray.push({"PTK_ExecForm":pid});
	 } 


	 /**
	  * @description 在打印机中定义一个变量
	  * @param {Number} pid 变量ID号码，取值范围：00—99;
	  * @param {Number} pmax 最大字符个数，取值范围：1—99
	  * @param {String} porder 对齐方式，L—左对齐，R—右对齐，C—居中，N—不对齐;
	  * @param {String} pmsg 提示内容，将会在KDU或打印机的LCD显示。
	  */
	 function PTK_DefineVariable(pid,pmax,porder,pmsg){
		printparamsJsonArray.push({"PTK_DefineVariable":pid+","+pmax+","+porder+","+pmsg});
	 }
	 
	 /**
	  * @description  在打印机中定义一个序列号
	  * @param {Number} id 序列号ID号码，取值范围：0—9;
	  * @param {Number} maxNum 序列号最大位数，取值范围：1—40；
	  * @param {String} ptext 对齐方式，L—左对齐，R—右对齐，C—居中，N—不对齐;
	  * @param {String} pstr  序列号的变化规律；由”+”或”-”加上一个数字，再加上一个变化标志（D –十进制，B –二进制，O – 八进制，H –十六进制组成：“+1”=每次增加1, 默认按照十进制计算：如1234，1235，1236，…；“+3D”=每次增加3，按照十进制计算，同上；“-1B”=每次减少1，按照二进制计算：如1111，1110，1101，…；“-4O”=每次减少4，按照八进制计算：如1234，1230，1224，…；“-6H”=每次减少6，按照十六进制计算：如1234，122E，1228，…；
	  * @param {String} pMsg 提示内容，将会在KDU或打印机的LCD显示。
	  */
	 function PTK_DefineCounter(id,maxNum,ptext,pstr,pMsg){
		printparamsJsonArray.push({"PTK_DefineCounter":id+","+maxNum+","+ptext+","+pstr+","+pMsg});
	 } 
	
	 /**
	  * @description 打印机开始给变量或序列号赋初始值
	  */
	 function PTK_Download(){
		printparamsJsonArray.push({"PTK_Download":""});
	 } 
	 
	 /**
	  * @description 按定义顺序初始化变量或序列号
	  * @param {String} pstr 要设置的初始值的字符串
	  */
	 function PTK_DownloadInitVar(pstr){
		printparamsJsonArray.push({"PTK_DownloadInitVar":pstr});
	 } 
	
	
	/**
	 * @description  命令打印机开始打印标签，在表单中使用，结合序列号或变量使用。
	 * @param {Number} Number 打印标签的数量，取值范围：1—65535；
	 * @param {Number} cpnumber 每张标签的复制份数，取值范围：1—65535；
	 */
	function PTK_PrintLabelAuto(Number,cpnumber){
		printparamsJsonArray.push({"PTK_PrintLabelAuto":Number+","+cpnumber});
	}
	
	
	 //*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
						
		
	 /**
	 * @@description 超高频RFID标签读写及相关（UHF）
	 * =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= 
	 */	 
	
	 /**
	  * @description RFID标签探测校准
	  */
	 function PTK_RFIDCalibrate(){
		printparamsJsonArray.push({"PTK_RFIDCalibrate":""});
	 } 
		
	 /**
	  * @description 写超高频RFID标签数据；RFID写入和读取之前必须进行RFID校准，否则会RFID读取和打印失败（打印机会报RFID打印出错并在标签上打印void0的字样）。注意：不是每次写入RFID数据之前都需要进行RFID探测校准，一种规格的标签只需要进行一次即可。
	  * 换不同规格的RFID标签打印时也需要进行RFID校准
	  * RFID探测校准：G系列：长按进纸（FEED）键一键校准  TXR系列：按测纸键一键校准 若不能一键校准可能是版本过低，进入液晶屏菜单找到“RFID探测校准”进行校准；若校准过程中提示纸张检测出错，请检查标签纸是否安装正确，有必要的时候根据标签的定位类型移动纸张探测器的位置和选定正确的探测方式（黑标定位 - 反射，穿孔定位 — 穿透）；若多次提示校准失败，可将标签换一个方向后尝试再次校准
	 *手动设置RFID探测偏移 将标签芯片到标签底部边缘的距离L设置到RFID偏移 当自动校准值写入RFID失败或无法一键校准时可用此方式设置RFID偏移
	 *RFID写入失败时，标签标签打印的错误标识解析 VOID0:扫描不到RFID标签。可能的原因：1、标签芯片是坏的 2、读功率太小 3、RFID偏移值偏差太大  4、没有做RFID探测校准； VOID1:写入RFID数据失败。可能的原因：1、RFID偏移值偏差大 2、写入的数据位数不符合要求（可2的倍数或4的倍数等等尝试）3、当前标签被锁定 4、当前标签以被写过一次，不能被再次写入； VOID2:扫描不到新的RFID标签；VOID3:扫描到多张RFID标签。可调小读功率或者重新做RFID探测校准
	  * @param {Number} nRWMode RFID读写方式。取值：0 或 1，参数值及说明如下：0 - 读RFID数据（预留，暂不生效）1 - 写RFID数据
	  * @param {Number} nWForm 数据写入格式。取值：0 或1，数值及说明如下：0 - HEX  1 - ASCII
	  * @param {Number} nStartBlock 写入起始块，参数类型为正整数
	  * @param {Number} nWDataNum 写入数据字节数，参数类型为正整数
	  * @param {Number} nWArea 写入区域。参数类型及说明如下： 0 - Reserved（保留区）；1 - EPC； 3 - USER；
	  * @param {String} Data 超高频RFID待写入数据
	  */
	 function PTK_RWRFIDLabel(nRWMode,nWForm,nStartBlock,nWDataNum,nWArea,Data){
		printparamsJsonArray.push({"PTK_RWRFIDLabel":nRWMode+","+nWForm+","+nStartBlock+","+nWDataNum+","+nWArea+","+Data});
	 }
	 
	 
	 /**
	  * @description  写超高频RFID标签数据，RFID 数据不会被PTK_ClearBuffer()清除
	  * @param {Number} nRWMode RFID读写方式。取值：0 或 1，参数值及说明如下：0 - 读RFID数据（预留，暂不生效）1 - 写RFID数据
	  * @param {Number} nWForm 数据写入格式。取值：0 或1，数值及说明如下：0 - HEX  1 - ASCII
	  * @param {Number} nStartBlock 写入起始块，参数类型为正整数
	  * @param {Number} nWDataNum 写入数据字节数，参数类型为正整数
	  * @param {Number} nWArea 写入区域。参数类型及说明如下： 0 - Reserved（保留区）；1 - EPC； 3 - USER；
	  * @param {String} Data 超高频RFID待写入数据
	  */
	 function PTK_RWRFIDLabelEx(nRWMode,nWForm,nStartBlock,nWDataNum,nWArea,Data){
	 	printparamsJsonArray.push({"PTK_RWRFIDLabelEx":nRWMode+","+nWForm+","+nStartBlock+","+nWDataNum+","+nWArea+                                            ","+Data});
	 } 
	 
	 /**
	  * @description 设置RFID标签密码和锁定RFID标签
	  * @param {Number} OperationMode 操作方式。取值：0 – 4的正整数，参数值及说明如下：0 - 解锁 1 - 锁定 2 - 完全解锁 3 - 完全锁定 4 - 密码写入
	  * @param {Number} OperationnArea 操作区域。取值：0 – 4的正整数，参数值及说明如下： 0 - 销毁密码区 1 - 访问密码区 2 - EPC 3 - TID 4 - USER
	  * @param {String} password 访问密码，格式限定为8位
	  */
	 function PTK_SetRFLabelPWAndLockRFLabel(OperationMode,OperationnArea,password){
	 	printparamsJsonArray.push({"PTK_SetRFLabelPWAndLockRFLabel":OperationMode+","+OperationnArea+","+password});
	 }
	
	
	 /**
	  * @description 编码RFID的PC值或国标的编码头
	  * @param {String} PCValue RFID的PC值或国标的编码头，数据格式为16进制。
	  */
	 function PTK_EncodeRFIDPC(PCValue){
	 	printparamsJsonArray.push({"PTK_EncodeRFIDPC":PCValue});
	 }
		
	 
	 /**
	  * @description  超高频RFID标签读写设置
	  * @param {Number} ReservationParameters 预留参数，默认值为0
	  * @param {Number} ReadWriteLocation RFID读写位置,默认为0，单位mm。取值：0 – 999的正整数
	  * @param {Number} ReadWriteArea 预留参数，默认值为0
	  * @param {Number} MaxErrNum 读写错误重试次数。取值：0 – 9的正整数，默认1
	  * @param {Number} ErrProcessingMethod 预留参数，默认值为0
	  */
	 function PTK_SetRFID(ReservationParameters,ReadWriteLocation,ReadWriteArea,MaxErrNum,ErrProcessingMethod){
		printparamsJsonArray.push({"PTK_SetRFID":ReservationParameters+","+ReadWriteLocation+","+ReadWriteArea+                                              ","+MaxErrNum+","+ErrProcessingMethod});
	 }

     /**
	  * @description 读取超高频RFID标签数据。支持串口、USB、网络读取 若读取数据超时请检查是否进行了RFID探测校准 其它值请查看msg信息。  读取到的数  若有ERROR标识，则表示没有读到合适的数据  错误码格式：ERROR+错误区域+错误代码（例：ERROR+TID+EPC0003） 错误码解析：0003:无法读取新标签的TID   0004:读到写入失败  0005:读取写过的标签的TID，但无法读取新标签的TID   0006:重新盘点到多张新标签
	  * @param {Number} DataBlock 选择读取数据区域。参数值及说明如下 ： 0 - TID； 1 - EPC； 2 - TID+EPC； 3 - USER
	  * @param {Number} RFPower 设置读功率，单位dBm。取值： 0 – 30的正整数。设置为0时，默认读功率为23dBm
	  * @param {Number} bFeed 读取后是否向前走一张标签。取值：0或1，参数值及说明如下：  0 - 读取后不走出该标签  1 - 读取后走出该标签
	  * @param {String} dataName 自定义读取数据的名称
	  * @param {Number} dataSize 读取数据的长度，参数类型为正整数
	  */
	 function PTK_ReadRFIDLabelData(DataBlock,RFPower,bFeed,dataName,dataSize){
		printparamsJsonArray.push({"PTK_ReadRFIDLabelData":DataBlock+","+RFPower+","+bFeed+","+dataName+","+dataSize});
	 }
  
     /**
	  * @description 打印一张标签，并返回RFID数据。 读取到的数据若有ERROR标识，则表示没有读到合适的数据 错误码格式：ERROR+错误区域+错误代码（例：ERROR+TID+EPC0003）错误码解析：0003:无法读取新标签的TID   0004:读到写入失败  0005:读取写过的标签的TID，但无法读取新标签的TID   0006:重新盘点到多张新标签
	  * @param {Number} DataBlock 选择读取数据区域。参数值及说明如下： 0 - TID； 1 -  EPC； 2 -  TID+EPC； 3 - USER
	  * @param {String} dataName 自定义读取数据的名称
	  * @param {Number} dataSize 读取数据的长度，参数类型为正整数
	  */  
	 function PTK_RFIDEndPrintLabel(DataBlock,dataName,dataSize){
		printparamsJsonArray.push({"PTK_RFIDEndPrintLabel":DataBlock+","+dataName+","+dataSize});
	 }


	 /**
	  * @description 打印一张标签，并返回RFID数据和打印机的状态 ；仅支持V7.61以上固件；读取到的数据若有ERROR标识，则表示没有读到合适的数据。错误码格式：ERROR+错误区域+错误代码（例：ERROR+TID+EPC0003 ）错误码解析：0003:无法读取新标签的TID   0004:读到写入失败  0005:读取写过的标签的TID，但无法读取新标签的TID   0006:重新盘点到多张新标签
	  * @param {Number} DataBlock 选择读取数据区域。参数值及说明如下： 0 - TID； 1 -  EPC； 2 -  TID+EPC； 3 - USER
	  * @param {String} dataName 自定义读取数据的名称
	  * @param {Number} dataSize 读取数据的长度，参数类型为正整数
	  * @param {String} printerStatus 自定义打印机状态名称 。返回数据格式为W1XXXX，XXXX为打印机状态代码
	  * @param {Number} statusSize 打印机状态数据长度，参数类型为正整数
	  */
	 function PTK_RFIDEndPrintLabelFeedBack(DataBlock,dataName,dataSize,printerStatus,statusSize){
		printparamsJsonArray.push({"PTK_RFIDEndPrintLabelFeedBack":DataBlock+","+dataName+","+dataSize+","+printerStatus+                                              ","+statusSize});
	 }
	 
	 
	 /**
	  * @description  设置读取RFID数据时标签前进到最佳读写位置时的速度
	  * @param {Number} speed 标签前进到最佳读写位置时的速度
	  */
	 function PTK_SetReadRFIDForwardSpeed(speed){
	 	printparamsJsonArray.push({"PTK_SetReadRFIDForwardSpeed":speed});
	 }
	 
	 
	 /**
	  * @description 设置读取RFID数据时标签回退到打印线时的速度
	  * @param {Number} speed 标签回退到打印线时的速度
	  */
	 function PTK_SetReadRFIDBackSpeed(speed){
	 	printparamsJsonArray.push({"PTK_SetReadRFIDBackSpeed":speed});
	 }
	
	
	 //*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
	
	
	 /**
	 * @@description 高频RFID标签读写及相关（HF）
	 * =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= 
	 */	
	 
	 /**
	  * @description  写高频RFID标签数据。RFID写入和读取之前必须进行RFID校准（进行校准前请先设置高频RFID标签的协议），否则会RFID读取和打印失败（打印机会报RFID打印出错并在标签上打印void0的字样）。注意：不是每次写入RFID数据之前都需要进行RFID探测校准，一种规格的标签只需要进行一次即可。换不同规格的RFID标签打印时也需要进行RFID校准。RFID探测校准：长按进纸（FEED）键一键校准	若校准过程中提示纸张检测出错，请检查标签纸是否安装正确，有必要的时候根据标签的定位类型移动纸张探测器的位置和选定正确的探测方式（黑标定位 - 反射，穿孔定位 — 穿透）若多次提示校准失败，可将标签换一个方向或检查高频RFID的协议设置，然后尝试再次校准
	  * @param {String} RWMode RFID读写方式。参数取值及说民如下：  R - 读RFID数据（预留，暂不生效）   W - 写RFID数据
	  * @param {Number} StartBlock 写入起始块，参数类型为正整数
	  * @param {Number} BlockNum  写入块的个数，参数类型为正整数
	  * @param {String} Data  高频RFID待写入数据
	  * @param {Number} Varible FID数据是否为序列号。取值：0 或1，参数值及说明如下：0 - 常量数据   1 - 序列号数据，预留参数，暂时无效
	  */
	 function PTK_RWHFLabel(RWMode,StartBlock,BlockNum,Data,Varible){
		printparamsJsonArray.push({"PTK_RWHFLabel":RWMode+","+StartBlock+","+BlockNum+","+Data+","+Varible});
	 }
	
	 
	 /**
	  * @description 高频RFID标签读写设置
	  * @param {String} WForm: 读写数据类型。参数值及说明如下：A - ASCII H - HEX  默认为ASCII 格式
	  * @param {Number} ProtocolType 协议类型。参数值及说明如下：1 - ISO 15693 协议 2 - ISO 14443 协议 3-NTAG
	  * @param {Number} MaxErrNumd 读写错误重试次数。取值：0 – 9的正整数，默认3
	  */
	 function PTK_SetHFRFID(WForm,ProtocolType,MaxErrNumd){
		printparamsJsonArray.push({"PTK_SetHFRFID":WForm+","+ProtocolType+","+MaxErrNumd});
	 }
	
	 /**
	  * @description 读取高频RFID标签数据。支持串口、USB、网络读取。若读取数据超时请检查是否进行了RFID探测校准。 读取到的数据若有ERROR标识，则表示没有读到合适的数据  错误码格式：ERROR+ BLOCK+ERRORTYPE（例：ERROR+BLOCK+0001）ERRORTYPE解析：0001：没有一个BLOCK数据读取成功。0002：能读到UID ,但过滤失败；即重复读到同一张高频RFID标签数据
	  * @param {Number} StartBlock 读取起始块，参数类型为正整数
	  * @param {Number} BlockNum 读取块的个数，参数类型为正整数。读取的数据为从StartBlock开始到StartBlock+BlockNum-1块的数据
	  * @param {String} pFeed 读取后是否向前走一张标签，取值：Y或N，参数值及说明如下：  Y - 读取后走出该标签    N - 读取后不走出该标签
	  * @param {String} dataName 自定义读取数据的名称
	  * @param {Number} dataSize 读取数据的长度，参数类型为正整数
	  */
	 function PTK_ReadHFLabelData(StartBlock,BlockNum,pFeed,dataName,dataSize){
		printparamsJsonArray.push({"PTK_ReadHFLabelData":StartBlock+","+BlockNum+","+pFeed+","+dataName+","+dataSize});
     }	
	 
	 /**
	  * @description  读取高频RFID标签的UID。支持串口、USB、网络读取。若读取数据超时请检查是否进行了RFID探测校准。读取到的数据若有ERROR标识，则表示没有读到合适的数据。错误码格式：ERROR+UID+ERRORTYPE（例：EERROR+UID+0001）ERRORTYPE解析：0001：读UID失败。0002：能读到UID ,但过滤失败；即重复读到同一张高频RFID标签数据
	  * @param {String} pFeed 读取后是否向前走一张标签，取值：Y或N，参数值及说明如下：  Y - 读取后走出该标签    N - 读取后不走出该标签	
	  * @param {String} dataName 自定义读取数据的名称
	  * @param {Number} dataSize 读取数据的长度，参数类型为正整数
	  */
	 function PTK_ReadHFLabeUID(pFeed,dataName,dataSize){
		printparamsJsonArray.push({"PTK_ReadHFLabeUID":pFeed+","+dataName+","+dataSize});
	 }	
	
      /**
       * @description 清除缓存中的UID数据记录
       */
      function PTK_ClearUIDBuffers(){
      		printparamsJsonArray.push({"PTK_ClearUIDBuffers":""});
      }	 
	  
	  
	 /**
	  * @description  置高频标签AFI的值
	  * @param {Number} nAFIValue 要设置的AFI的值
	  */
	 function PTK_SetHFAFI(nAFIValue){
	 	printparamsJsonArray.push({"PTK_SetHFAFI":nAFIValue});
	 }
	 
	 /**
	  * @description  设置高频标签DSFID的值
	  * @param {Number} nDSFIDValue 要设置的DSFID的值
	  */
	 function PTK_SetHFDSFID(nDSFIDValue){
	 	printparamsJsonArray.push({"PTK_SetHFDSFID":nDSFIDValue});
	 }
	
	 /**
	  * @description  设置高频标签EAS的值
	  * @param {String} EAS 要设置的EAS的值,取值：’E’或’R’.
	  */
	 function PTK_SetHFEAS(EAS){
	 	printparamsJsonArray.push({"PTK_SetHFEAS":EAS});
	 }
	
     /**
	  * @description  高频标签解密。注意：电子标签为HF 13.56M频段,且符合ISO 14443A协议的标签。
	  * @param {Number} key 选择keyA或者keyB进行解密。 1 - keyA  	2 - keyB
	  * @param {Number} nStartBlock 校验起始块。
	  * @param {Number} nBlockNum  校验块数。 
	  * @param {String} VerifyPassword 解密密码(十六进制)；默认值为FFFFFFFFFFFF。
	  */
	 function PTK_HFDecrypt(key,nStartBlock,nBlockNum,VerifyPassword){
		printparamsJsonArray.push({"PTK_HFDecrypt":key+","+nStartBlock+","+nBlockNum+","+VerifyPassword});
	 }
	
     /**
	  * @description  高频标签锁定。注意：电子标签为HF 13.56M频段,且符合ISO 14443A协议的标签。
	  * @param {Number} nStartBlock 设置锁定的起始块。（注：14443A协议设置范围有一个限制，即3*n（n为0/1/2/3/…）的块不能作为起始块）
	  * @param {Number} nBlockNum 设置锁定的块数
	  * @param {String} keyA 设置锁定的keyA密码。
	  * @param {String} keyB 设置锁定的keyB密码。
	  * @param {String} nControlByte  设置控制字，格式为十六进制。当设置为NULL时，默认值为FF078069
	  */
	 function PTK_LockHFLabel(nStartBlock, nBlockNum,keyA,keyB,nControlByte){
		printparamsJsonArray.push({"PTK_LockHFLabel":nStartBlock+","+nBlockNum+","+keyA+","+keyB+","+nControlByte});
	 }
	 
	 /**
	  * @description   锁定15693标签 AFI/DSFID
	  * @param {String} Identifier 锁定标识符。L-锁定AFI，U - 锁定DSFID
	  */
	 function PTK_LockHFIdentifier(Identifier){
	 	printparamsJsonArray.push({"PTK_LockHFIdentifier":Identifier});
	 }	 

     /**
	  * @description 锁定15693/NTAG块
	  * @param {Number} nStartBlock 设置锁定的起始块  
	  * @param {Number} nBlockNum 设置锁定的块数
	  */
	 function PTK_LockHFBlock(nStartBlock,nBlockNum){
		printparamsJsonArray.push({"PTK_LockHFBlock":nStartBlock+","+nBlockNum});
	 }
	
	 /**
	  * @description  设置密钥
	  * @param {Number} lockType 锁定设置。1 - 表示修改密钥后锁定；0 - 表示不锁定
	  * @param {String} keyA KeyA值
	  * @param {String} keyB keyB值
	  * @param {String} keyFx keyFx值
	  */
	 function PTK_SetHFKey(lockType,keyA,keyB,keyFx){
		printparamsJsonArray.push({"PTK_SetHFKey":lockType+","+keyA+","+keyB+","+keyFx});
	 }
	
	 /**
	  * @description  设置校验/修改/锁定CRC口令
	  * @param {Number} lockType 锁定设置。1 - 表示校验成功且修改完CRC口令后对CRC口令进行锁定；0 - 表示不锁定CRC口令
	  * @param {String} oldCRCCommand 旧CRC口令，用于校验，格式为16进制数
	  * @param {String} newCRCCommand 新CRC口令，用于校验，格式为16进制数
	  */
	 function PTK_SetHFCRCCommand(lockType,oldCRCCommand,newCRCCommand){
		printparamsJsonArray.push({"PTK_SetHFCRCCommand":lockType+","+oldCRCCommand+","+newCRCCommand});
	 }
	 
	 /**
	  * @description  设置校验/修改私有模式口令
	  * @param {Number} lockType 锁定设置。	1 - 表示校验成功且修改完私有模式口令后对私有模式口令进行锁定；0 - 表示不锁定私有模式口令
	  * @param {Number} oldPrivateCommand 旧私有模式口令，用于校验，格式为16进制数
	  * @param {Number} newPrivateCommand 新私有模式口令，用于校验，格式为16进制数
	  */
	 function PTK_SetHFPrivateCommand(lockType,oldPrivateCommand,newPrivateCommand){
		printparamsJsonArray.push({"PTK_SetHFPrivateCommand":lockType+","+oldPrivateCommand+","+newPrivateCommand});
	 }
	
	 /**
	  * @description 设置用户区锁定
	  * @param {Number} lockType 锁定设置。	1 - 使能锁定；0 - 不使能锁定。
	  * @param {Number} nStartBlock 锁定起始块
	  * @param {Number} nBlockNum 锁定块数
	  */
	 function PTK_LockHFUser(lockType,nStartBlock,nBlockNum){
		printparamsJsonArray.push({"PTK_LockHFUser":lockType+","+nStartBlock+","+nBlockNum});
	 }

     
	 /**
	  * @description 设置用户区锁定
	  * @param {String} CFG_Set_0x10 CFG Set 0x10功能参数，格式为十六进制
	  */
	 function PTK_SetHFCFG10(CFG_Set_0x10){
	 	printparamsJsonArray.push({"PTK_SetHFCFG10":CFG_Set_0x10});
	 }	 


     /**
	  * @description  设置用户区锁定
	  * @param {String} CFG_Set_0x80 CFG Set 0x80功能参数，格式为十六进制
	  */
	 function PTK_SetHFCFG80(CFG_Set_0x80){
	 	printparamsJsonArray.push({"PTK_SetHFCFG80":CFG_Set_0x80});
	 }	 
		
	
	 //*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
		
		
	 /**
	 * @@description 兼容API 旧版本
	 * =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= 
	 */	 
	
	 /**
	  * @description 打开通讯端口
	  * @param {Number} px
	  */
	 function OpenPort(px){
	 	printparamsJsonArray.push({"OpenPort":px});
	 }	
	 
	 /**
	  * @description 关闭通讯端口
	  */
	 function ClosePort(){
	 	printparamsJsonArray.push({"ClosePort":""});
	 }	
	 
     /**
	  * @description 设置PC机上串口的传输波特率
	  * @param {Number} BaudRate 串口波特率
	  * @param {Number} HandShake 是否使用硬件握手
	  */
	 function SetPCComPort(BaudRate,HandShake){
		printparamsJsonArray.push({"SetPCComPort":BaudRate+","+HandShake});
	  }


     /**
	  * @description  将打印机复位
	  */
	 function PTK_Reset(){
		printparamsJsonArray.push({"PTK_Reset":""});
	 }
	 
	 
	 /**
	  * @description  打印存储在RAM或FLASH存储器里的软字体的名称清单
	  */
	 function PTK_SoftFontList(){
		printparamsJsonArray.push({"PTK_SoftFontList":""});
	 }
	 
	 
	 /**
	  * @description 删除存储在RAM或FLASH存储器里的一个或所有的软字体
	  * @param {String} pid 软字体ID，取值范围：A—Z或 * ；如果pid = ‘*’,打印机将删除存储在RAM或FLASH存储器里所有的软字体
	  */
	 function PTK_SoftFontDel(pid){
		printparamsJsonArray.push({"PTK_SoftFontDel":pid});
	 }
		
	 /**
	  * @description  取消打印回转功能
	  */
	 function PTK_DisableBackFeed(){
		printparamsJsonArray.push({"PTK_DisableBackFeed":""});
	 }
	
	 /**
	  * @description  设置打印回转功能
	  * @param {Number} distance 回转距离,以点(dots)为单位
	  */
	 function PTK_EnableBackFeed(distance){
		printparamsJsonArray.push({"PTK_EnableBackFeed":distance});
	 }

     
	 /**
	  * @description  设置打印机的工作状态 
	  * @param {Number} state  D：设置打印机为热感印(热传导)状态；P：设置打印机为连续送纸状态(缺省)；L：设置打印机为打印一张标签后，暂停等待用户确定再打印下一张标签；(确定方式：1.按”FEED”键；2.在安装剥纸器情况下，当用户取走标签后自动打印下一张标签)；CN: 切纸状态，仅在切纸频率设置为0时有效，单次打印任务结束失效，N为打印数量，取值范围：1~30000，N缺省时打印一张切一张；N有效时打印完N张标签后切下标签，N: 设置打印机为安装剥纸器状态。注意: 1.	切纸刀与剥纸器不能同时安装；2.	如果打印机状态设置不正确时，打印机前面板的READY指示灯将闪烁，请参考打印机用户手册的故障排除章节。
	  */
	 function PTK_SetPrinterState(state){
		printparamsJsonArray.push({"PTK_SetPrinterState":state});
	 }
	 
	 /**
	  * @description 取消错误反馈 
	  */
	 function PTK_DisableErrorReport(){
		printparamsJsonArray.push({"PTK_DisableErrorReport":""});
	 }
	
     /**
	  * @description  设置错误反馈
	  */
	 function PTK_EnableErrorReport(){
		printparamsJsonArray.push({"PTK_EnableErrorReport":""});
	 }
	
     
	 /**
	  * @description  要求打印机立刻反馈错误报告
	  */
	 function PTK_FeedBack(){
		printparamsJsonArray.push({"PTK_FeedBack":""});
	 }	
	 
	 
	 /**
	  * @description 读取打印机端口内数据
	  * @param {String} dataName 自定义数据名称
	  * @param {Number} dataSize 读取数据长度
	  */
	 function PTK_ReadData(dataName,dataSize){
		printparamsJsonArray.push({"PTK_ReadData":dataName+","+dataSize});
	  } 
	  
	  
	
	 function PTK_ErrorReport(wPort,rPort,BaudRate,HandShake,TimeOut){
		printparamsJsonArray.push({"PTK_ErrorReport":wPort+","+rPort+","+BaudRate+","+HandShake+","+TimeOut});
	 }
	  
	  
	 function PTK_ErrorReportNet(PrintIPAddress,PrintetPort){
		printparamsJsonArray.push({"PTK_ErrorReportNet":PrintIPAddress+","+PrintetPort});
	  } 

	 function PTK_ErrorReportUSB(USBport){
		printparamsJsonArray.push({"PTK_ErrorReportUSB":USBport});
	 } 
	  
     
	 /**
	  * @description  调整print_text字间距
	  * @param {Number} gap 字间距调节值，以点(dots)为单位.取值范围为-99 — 99.
	  */
	 function PTK_SetFontGap(gap){
		printparamsJsonArray.push({"PTK_SetFontGap":gap});
	 }


	 function PTK_SetBarCodeFontName(Name,FontW,FontH){
		printparamsJsonArray.push({"PTK_SetBarCodeFontName":Name+","+FontW+","+FontH});
	 }

     
	 /**
	  * @description  将下载到打印机的字体与PTK_DrawText使用的字体ID  A~Z匹配
	  * @param {Number} StoreType  下载字体在打印机中的存储位置，0：SDRAM,  1：FLASH.
	  * @param {String} Fontname  重命名下载字体ID，取值范围：A-Z
	  * @param {String} DownloadFontName 下载字体在打印机中的名称
	  */
	 function PTK_RenameDownloadFont(StoreType,Fontname,DownloadFontName){
		printparamsJsonArray.push({"PTK_RenameDownloadFont":StoreType+","+Fontname+","+DownloadFontName});
	 }

     
	
	 function PTK_SetCharSets(BitValue,CharSets,CountryCode){
		printparamsJsonArray.push({"PTK_SetCharSets":BitValue+","+CharSets+","+CountryCode});
	 }
	 
	 function PTK_ReadRFTagDataNet(IPAddress,Port,nFeedbackPort,nRFPower,bFeed,strRFData){
	 	printparamsJsonArray.push({"PTK_ReadRFTagDataNet":IPAddress+","+Port+","+nFeedbackPort+","+nRFPower+","+bFeed+                                         ","+strRFData});
	 }
	 
	 
	 function PTK_ReadRFTagDataUSB(usbPort,nDataBlock,nRFPower,bFeed,strRFData){
	 	printparamsJsonArray.push({"PTK_ReadRFTagDataUSB":usbPort+","+nDataBlock+","+nRFPower+","+bFeed+                                         ","+strRFData});
	 }	 
	
	

	 function PTK_ReadHFTagUIDUSB(usbPort,pFeed,readbuffer){
		printparamsJsonArray.push({"PTK_ReadHFTagUIDUSB":usbPort+","+pFeed+","+readbuffer});
	 }
	 
	 
	 /**
	  * @description  设置打印机的撕纸偏移和定位偏移
	  * @param {Number} tear_offset 撕纸偏移，单位为 mm
	  * @param {Number} tph_offset 定位偏移，单位为 mm
	  */
	 function PTK_SetTearAndTphOffset(tear_offset,tph_offset){
	 		printparamsJsonArray.push({"PTK_SetTearAndTphOffset":tear_offset+","+tph_offset});
	 }
	
	 function PTK_AnyGraphicsDownload( pcxname,  filename,  ratio,  width,  height,  iDire){
		printparamsJsonArray.push({"PTK_AnyGraphicsDownload":pcxname+","+filename+","+ratio+","+width+","+height+","+iDire});
	 }
	 function PTK_GetErrState(){
		printparamsJsonArray.push({"PTK_GetErrState":""});
	}
	
	 function PTK_GetInfo(){
		printparamsJsonArray.push({"PTK_GetInfo":""});
	 }

	 /**
	  * @description  打印已存储在打印机RAM或FLASH存储器里的图形名称清单
	  */
	 function PTK_BinGraphicsList(){
		printparamsJsonArray.push({"PTK_BinGraphicsList":""});
	 }


	 /**
	  * @description  删除存储在打印机中的bin图形
	  * @param {String} pid 打印机内部存储的图形名称，最大长度为16个字符
	  */
	 function PTK_BinGraphicsDel(pid){
		printparamsJsonArray.push({"PTK_BinGraphicsDel":pid});
	 }


	 function PTK_RecallBinGraphics(px,py,name){
		printparamsJsonArray.push({"PTK_RecallBinGraphics":px+","+py+","+name});
	 }

	 
	 function PTK_GetUSBID(USBDeviceSerial){
		printparamsJsonArray.push({"PTK_GetUSBID":USBDeviceSerial});
	 }

	 //*=^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^= =^-^=
	 
	 function Status_M(Msg){
		 var status_t= parseInt(Msg.toString().replace("W10",""));
		 var status;
		 switch (status_t){
		 	case   0:		status="无错误"; 				break;
		 	case   1:		status="语法错误"; 				break;
		 	case   4:		status="正在打印中"; 			break;
		 	case  82:		status="碳带检测出错"; 			break;
		 	case  83:		status="标签检测出错"; 			break;
		 	case  86:		status="切刀检测出错"; 			break;
		 	case  87:		status="打印头未关闭"; 			break;
		 	case  88:		status="暂停状态"; 				break;
		 	case 108:		status="设置RFID写数据的方式和内容区域执行失败，输入参数错误"; 	break;
		 	case 109:		status="RFID标签写入数据失败，已达到重试次数"; 					break;
		 	case 110:		status="写入RFID数据失败，但未超过重试次数"; 					break;
		 	case 111:		status="RFID标签校准失败"; 									break;
		 	case 112:		status="设置RFID读取数据的方式和内容区域执行失败，输入参数错误"; 	break;
		 	case 116:		status="读取RFID标签数据失败"; 								break;
		 	default:		status="未知错误"; 											break;
		 }
		 return status;
	 }
	 
	 
	 
	 