<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Library Administration API",
 *     version="1.0.0",
 *     description="API documentation for Admin panel"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Use token from Sanctum"
 * )
 */
class SwaggerInfo
{
    // فقط للتوثيق
}
