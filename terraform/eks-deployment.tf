resource "kubernetes_deployment" "app_deployment" {
  depends_on = [aws_eks_node_group.eks_node_group]
  metadata {
    name = "postech-deployment"
    labels = {
      app = "postech-deployment"
    }
  }

  spec {
    replicas = 2

    selector {
      match_labels = {
        app = "postech-deployment"
      }
    }

    template {
      metadata {
        labels = {
          app = "postech-deployment"
        }
      }

      spec {
        container {
          image = var.appImage
          name  = "backend"

        #   lifecycle {
        #     post_start {
        #       exec {
        #         command = ["/bin/sh", "-c", "php artisan migrate && php artisan db:seed"]
        #       }
        #     }
        #   }

          env_from {
            config_map_ref {
              name = kubernetes_config_map.app_config.metadata.0.name
            }
          }

          env_from {
            secret_ref {
              name = kubernetes_secret.app_secret.metadata.0.name
            }
          }

          port {
            container_port = 80
          }
        }
      }
    }
  }
}
