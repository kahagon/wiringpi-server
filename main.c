#include "sapi/embed/php_embed.h"
#include "scripts.h"


int wiringpid_eval_php_code(char *code) {
    int ret = 0;

    zend_try {
        ret = zend_eval_string(code, NULL, (char *)"" TSRMLS_CC);
    } zend_catch {

    } zend_end_try();

    return ret == FAILURE;
}

int wiringpid_daemonize() {
    int result = 0;
    result = daemon(1, 0);
    return result;
}

int main(int argc, char* argv[]) {

    int result = wiringpid_daemonize();
    if (0>result) {
        printf("failed to daemonize\n");
        return 2;
    }

    PHP_EMBED_START_BLOCK(argc, argv);

    wiringpid_eval_php_code(script_phpinfo_php);

    PHP_EMBED_END_BLOCK();
    return 0;
}
