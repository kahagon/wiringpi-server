CC=gcc
CFLAGS=-g -Wall
OBJS=main.o

.c.o:
	$(CC) $(CFLAGS) `php-config --includes` -c -o $@ $<

wiringpid: $(OBJS)
	$(CC) $(CFLAGS) `php-config --ldflags` -o $@ $^ -lphp5

scripts.h:
	php scripts.h.php scripts

main.o: scripts.h

clean:
	rm -f wiringpid scripts.h $(OBJS)
