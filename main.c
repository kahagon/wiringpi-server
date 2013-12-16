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

int main(int argc, char* argv[]) {
    PHP_EMBED_START_BLOCK(argc, argv);

    wiringpid_eval_php_code(script_phpinfo_php);

    PHP_EMBED_END_BLOCK();
    return 0;
}
