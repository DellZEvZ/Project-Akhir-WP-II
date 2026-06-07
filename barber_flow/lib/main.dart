import 'package:flutter/material.dart';
import 'theme.dart';
import 'pages/welcome_page.dart';

void main() {
  runApp(const BarberFlowApp());
}

class BarberFlowApp extends StatelessWidget {
  const BarberFlowApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Barber Flow',
      debugShowCheckedModeBanner: false,
      theme: buildAppTheme(),
      home: const WelcomePage(),
    );
  }
}
