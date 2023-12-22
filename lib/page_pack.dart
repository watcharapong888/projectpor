import 'dart:io';
import 'package:flutter/material.dart';
import 'package:file_picker/file_picker.dart';

class MyApp2 extends StatelessWidget {
  const MyApp2({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'File Downloader',
      theme: ThemeData(
        primarySwatch: Colors.blue,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      home: const PickPage(),
    );
  }
}

class PickPage extends StatefulWidget {
  const PickPage({super.key});

  @override
  // ignore: library_private_types_in_public_api
  _PickPage createState() => _PickPage();
}

class _PickPage extends State<PickPage> {
  FilePickerResult? result;
  String? _fileName;
  PlatformFile? pickedfile;
  bool isLoading = false;
  File? fileToDisplay;

  void pickfile() async {
    try {
      setState(() {
        isLoading = true;
      });

      result = await FilePicker.platform.pickFiles(
        type: FileType.custom,
        allowedExtensions: ['png', 'pdf'],
        allowMultiple: false,
      );

      if (result != null) {
        _fileName = result!.files.first.name;
        pickedfile = result!.files.first;
        fileToDisplay = File(pickedfile!.path.toString());

        print("File name $_fileName");
      }

      setState(() {
        isLoading = false;
      });
    } catch (e) {
      print(e);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Pick File'),
      ),
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Center(
            child: isLoading
                ? const CircularProgressIndicator()
                : TextButton(
                    onPressed: () {
                      pickfile();
                    },
                    child: const Text('Pick file')),
          ),
          if (pickedfile != null)
            SizedBox(
              height: 300,
              width: 400,
              child: Image.file(fileToDisplay!),
            )
        ],
      ),
    );
  }
}
