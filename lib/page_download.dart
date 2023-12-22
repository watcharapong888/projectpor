import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:path_provider/path_provider.dart';
import 'package:permission_handler/permission_handler.dart';
import 'dart:io';


class MyApp1 extends StatelessWidget {
  const MyApp1({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'File Downloader',
      theme: ThemeData(
        primarySwatch: Colors.blue,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      home: const DownloadPage(),
    );
  }
}

class DownloadPage extends StatefulWidget {
  const DownloadPage({super.key});

  @override
  // ignore: library_private_types_in_public_api
  _DownloadPageState createState() => _DownloadPageState();
}

class _DownloadPageState extends State<DownloadPage> {
  String _status = '';

  Future<void> _downloadFile() async {
    const url = 'https://fluttercampus.com/sample.pdf';
    final response = await http.get(Uri.parse(url));

    if (response.statusCode == 200) {
      final directory = await getExternalStorageDirectory();
      if (directory != null) {
        final filePath = '${directory.path}/sample.pdf';
        File file = File(filePath);
        await file.writeAsBytes(response.bodyBytes);
        setState(() {
          _status = 'Downloaded: $filePath';
        });
      } else {
        setState(() {
          _status = 'Error: Unable to access directory';
        });
      }
    } else {
      setState(() {
        _status = 'Error: Failed to download file';
      });
    }
  }

 Future<bool> _requestPermission() async {
  var storagePermission = await Permission.storage.request();
  if (storagePermission.isGranted) {
    _downloadFile();
    return true;
  } else {
    await openAppSettings(); 
    setState(() {
      _status = 'Error: Storage permission not granted';
    });
    return false;
  }
}


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Download File'),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            ElevatedButton(
              onPressed: _requestPermission,
              child: const Text('Download'),
            ),
            const SizedBox(height: 20),
            Text(_status),
          ],
        ),
      ),
    );
  }
}
