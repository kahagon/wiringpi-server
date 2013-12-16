CC=gcc
CFLAGS=-g -Wall
OBJS=main.o

.c.o:
	$(CC) $(CFLAGS) `php-config --includes` -c -o $@ $<

wiringpid: $(OBJS)
	$(CC) $(CFLAGS) `php-config --ldflags` -o $@ $^ -lphp5

main.o: scripts.h

clean:
	rm -f wiringpid $(OBJS)
