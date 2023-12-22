import 'package:flutter/material.dart';
import 'package:flutter_application_1/bloc/text_bloc.dart';
import 'package:flutter_application_1/bloc/text_event.dart';
import 'package:flutter_application_1/bloc/text_state.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

class YourWidget extends StatelessWidget {
  const YourWidget({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (context) => TextListBloc(),
      child: const YourWidgetBody(),
    );
  }
}

class YourWidgetBody extends StatelessWidget {
  const YourWidgetBody({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final bloc = BlocProvider.of<TextListBloc>(context);

    return Scaffold(
      body: BlocBuilder<TextListBloc, TextListState>(
        builder: (context, state) {
          return Container(
            color: Color.fromARGB(255, 181, 231, 255),
            child: ListView(
              padding: const EdgeInsets.only(top: 45),
              children: ListTile.divideTiles(
                context: context,
                tiles: List.generate(
                  state.textItems.length,
                  (index) {
                    final text = state.textItems[index];
                    return ListTile(
                      leading: CircleAvatar(
                        backgroundColor: Color.fromARGB(255, 0, 26, 255),
                        child: Text('${index + 1}'), // แสดงหมายเลขรายการ
                      ),
                      title: Text(text),
                      trailing: IconButton(
                        icon: const Icon(Icons.remove),
                        onPressed: () {
                          bloc.add(RemoveTextEvent(index));
                        },
                      ),
                    );
                  },
                ),
                color: Color.fromARGB(255, 55, 0, 255), // สีของเส้นแบ่ง
              ).toList(),
            ),
          );
        },
      ),
      floatingActionButton: Column(
        mainAxisAlignment: MainAxisAlignment.end,
        crossAxisAlignment: CrossAxisAlignment.end,
        children: [
          FloatingActionButton(
            onPressed: () {
              bloc.add(AddRandomTextEvent());
            },
            tooltip: 'Button 1',
            child: const Icon(Icons.add),
          ),
          const SizedBox(height: 16),
          // FloatingActionButton(
          //   onPressed: () {
          //     bloc.add(RefreshListEvent());
          //   },
          //   tooltip: 'Button 2',
          //   child: const Icon(Icons.refresh),
          // ),
        ],
      ),
    );
  }
}
