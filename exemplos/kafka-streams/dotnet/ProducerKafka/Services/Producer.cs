using Confluent.Kafka;
using ProducerKafka.Models;

namespace ProducerKafka
{
    public class Producer
    {
        private ProducerConfig _config;
        private AdminClientConfig _adminClientConfig;
        public Producer()
        {
            Console.WriteLine("Producer");
            this._config = new ProducerConfig
            {
                BootstrapServers = "kafka:9092",
            };
            this._adminClientConfig = new AdminClientConfig { BootstrapServers = "kafka:9092" };
        }

        public async Task<DeliveryResult<Null, string>> Execute(MessageKafka messageKafka)
        {
            Console.WriteLine($"Producer '{messageKafka.Message}' in '{messageKafka.Topic.Name}'");
            var topicExistend= this.checkExistTopic(messageKafka.Topic.Name);
            if (topicExistend.Equals(false))
                throw new Exception($"Topico {messageKafka.Topic.Name} invalido");

            var producer = new ProducerBuilder<Null, string>(this._config).Build();

            var result = await producer.ProduceAsync(messageKafka.Topic.Name, new Message<Null, string> { Value = messageKafka.Message });
            return result;
        }

        public bool checkExistTopic(string topic)
        {
            using var client = new AdminClientBuilder(this._adminClientConfig).Build();

            var metadata = client.GetMetadata(topic, TimeSpan.FromSeconds(10));
            return metadata.Topics.First().Error.IsError.Equals(false);
        }
    }

}