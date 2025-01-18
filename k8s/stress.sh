#!/bin/bash
for i in {1..10000}; do
  curl http://192.168.49.2:31100/api/establishment/orders
  sleep $1
done
