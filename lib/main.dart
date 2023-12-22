import 'package:flutter/material.dart';
import 'package:flutter_application_1/page_download.dart';
import 'package:flutter_application_1/page_pack.dart';
import 'package:flutter_application_1/page_list.dart';
import 'package:flutter_application_1/page_link.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Your App',
      theme: ThemeData(
        primarySwatch: Colors.blue,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      initialRoute: '/',
      routes: {
        '/': (context) => const HomeScreen(),
        '/page_download': (context) => const MyApp1(),
        '/page_pick': (context) => const MyApp2(),
        '/page_link': (context) => const MyApp3(),
        '/page_list': (context) => const MyApp4(),
      },
    );
  }
}

class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Home'),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            const Text(
              'Home Screen',
              style: TextStyle(fontSize: 24),
            ),
            ElevatedButton(
              onPressed: () {
                Navigator.pushNamed(context, '/page_pick'); // เปิดหน้า page1
              },
              child: const Text('page_pick_file'),
            ),
            ElevatedButton(
              onPressed: () {
                Navigator.pushNamed(context, '/page_download');
              },
              child: const Text('page_download'),
            ),ElevatedButton(
              onPressed: () {
                Navigator.pushNamed(context, '/page_link');
              },
              child: const Text('page_link'),
            ),ElevatedButton(
              onPressed: () {
                Navigator.pushNamed(context, '/page_list');
              },
              child: const Text('page_list'),
            ),
          ],
        ),
      ),
    );
  }
}
