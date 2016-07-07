#Messages
This bundle provides basic framework for transfering data.

It is based on simple idea: to have a unified process of sending, receiving, packing(serializing) and unpacking(unserializing) data across multiple(or single one) systems.

This bundle is meant to be used for client-server comunication. But it is usable in any other form or communication.

The bundle itself does not provide any way of actual "sending" of the messages. It can be therefore used with e.g. rabbitMQ or HTTP.

The bundle defines basic "protocol" for sending the messages by defing all the field that are required.

Each message is "signed" with very basic method. Each sender and receiver has it's id(public key) and secret(secret key).

##Each message sent(serialized) has:
- uid - unique identification of the message
- clientId - unique identification of the client which is either sender of this message or which is the message ment to be sent to
- jsonData - the data which are sent in the message
- hash - simple hash of the message information and data
- type - type of the message. This field is used while unpacking the message
- parrentMessageUid - uid of the message which is this message responding to
- sender - identification of the sender - it can be anything you need. It is ment to be used by the lower level classes which are responsible for actual sending of the message(via rabbitMQ, HTTP, etc.)
- destination - identification of the sender - it can be anything you want. It is ment to be used by the lower level classes which are responsible for actual sending of the message(via rabbitMQ, HTTP, etc.)
- user - identification of the user which made the message. If you need to know who is responsible for the message.

