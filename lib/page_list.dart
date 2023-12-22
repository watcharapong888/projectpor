import 'package:flutter/material.dart';
import 'package:flutter_application_1/bloc/text_bloc.dart';
import 'package:flutter_application_1/bloc/text_ui.dart';
import 'package:flutter_bloc/flutter_bloc.dart';


class MyApp4 extends StatelessWidget {
  const MyApp4({super.key});
 @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Flutter BLoC Text Example',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: YourWidget(),
    );
  }
}