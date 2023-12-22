abstract class TextListEvent {}

class AddRandomTextEvent extends TextListEvent {
}


class RemoveTextEvent extends TextListEvent {
  final int indexToRemove;
  RemoveTextEvent(this.indexToRemove);
}

class RefreshListEvent extends TextListEvent {
}