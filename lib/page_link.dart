import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';


class MyApp3 extends StatelessWidget {
  const MyApp3({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        appBar: AppBar(
          title: const Text('WebView'),
        ),
        body: const WebViewWidget(),
      ),
    );
  }
}

class WebViewWidget extends StatefulWidget {
  const WebViewWidget({super.key});

  @override
  // ignore: library_private_types_in_public_api
  _WebViewWidgetState createState() => _WebViewWidgetState();
}

class _WebViewWidgetState extends State<WebViewWidget> {
  final String webView = 'https://www.youtube.com//';
  // final String webView = 'https://bwr.rmuti.ac.th/';
  bool _isLoadingPage = true; // เพิ่มตัวแปรสำหรับตรวจสอบว่าหน้าจอกำลังโหลดหรือไม่

  @override
  Widget build(BuildContext context) {
    return Scaffold(

      body: Stack(
        children: [
          WebView(
            initialUrl: webView,
            javascriptMode: JavascriptMode.unrestricted,
            onPageFinished: (String url) {
              // เมื่อหน้าจอโหลดเสร็จสมบูรณ์ ให้ปิดการแสดง LinearProgressIndicator
              setState(() {
                _isLoadingPage = false;
              });
            },
          ),
          // เพิ่ม LinearProgressIndicator เพื่อแสดงเมื่อหน้าจอกำลังโหลด
          if (_isLoadingPage)
            const Positioned(
              left: 0.0,
              right: 0.0,
              bottom: 0.0,
              child: LinearProgressIndicator(
                backgroundColor: Colors.grey,
                valueColor: AlwaysStoppedAnimation<Color>(Colors.blue),
              ),
            ),
        ],
      ),
    );
  }
}
