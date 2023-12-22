
import 'dart:math';
class TextListState {
  final List<String> textItems;

  TextListState(this.textItems);

  TextListState.initial() : textItems = List<String>.generate(2, (index) => _generateRandomText());

  static String _generateRandomText() {
  // สร้างข้อความแบบสุ่ม
  final random = Random();
  const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  const length = 1; // ยาวของข้อความที่จะสร้าง

  return String.fromCharCodes(Iterable.generate(
    length, (_) => chars.codeUnitAt(random.nextInt(chars.length)),
  ));
}
}
