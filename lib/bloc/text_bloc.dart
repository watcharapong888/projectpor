import 'package:bloc/bloc.dart';
import 'package:flutter_application_1/bloc/text_event.dart';
import 'package:flutter_application_1/bloc/text_state.dart';
import 'dart:math';

class TextListBloc extends Bloc<TextListEvent, TextListState> {
  TextListBloc() : super(TextListState.initial()) {
    on<AddRandomTextEvent>((event, emit) {
      final updatedList = List<String>.from(state.textItems)
        ..add(_generateRandomText());
      emit(TextListState(updatedList));
    });

    on<RemoveTextEvent>((event, emit) {
      final updatedList = List<String>.from(state.textItems)
        ..removeAt(event.indexToRemove);
      emit(TextListState(updatedList));
    });
    on<RefreshListEvent>((event, emit) {
      final List<String> newList = [];
      for (int i = 0; i < 10; i++) {
        newList.add(_generateRandomText());
      }
      emit(TextListState(newList));
    });
  }

  String _generateRandomText() {
  // สร้างข้อความแบบสุ่ม
  final random = Random();
  const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  const length = 1; // ยาวของข้อความที่จะสร้าง

  return String.fromCharCodes(Iterable.generate(
    length, (_) => chars.codeUnitAt(random.nextInt(chars.length)),
  ));
}
}
