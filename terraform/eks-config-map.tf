resource "kubernetes_config_map" "app_config" {
  depends_on = [aws_db_instance.mysql]
  metadata {
    name = "app-config"
  }

  data = {
    DB_CONNECTION        = "mysql"
    DB_HOST              = aws_db_instance.mysql.endpoint
    DB_PORT              = var.DatabasePort
    APP_ENV              = "local"
    APP_INTEGRATION_URI  = "postech-service.default.svc.cluster.local"
    APP_NOTIFICATION_URI = "postech-service.default.svc.cluster.local/v1/webhooks"
  }
}
