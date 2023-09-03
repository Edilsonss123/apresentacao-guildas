using Confluent.Kafka;
using System.Net;

namespace ConsumerKafka
{
    class Consumer
    {
        string[] topics;
        ConsumerConfig config;
        public Consumer()
        {

            Console.WriteLine("Consumer");
            this.config = new ConsumerConfig
            {
                BootstrapServers = "kafka:9092",
                GroupId = "group-teste-0",
                AutoOffsetReset = AutoOffsetReset.Earliest
            };

            this.topics = new string[1] {"teste"};
        }

        public void Execute()
        {
            Console.WriteLine("Tô esperando mensagens");

            using (var consumer = new ConsumerBuilder<Ignore, string>(config).Build())
            {
                consumer.Subscribe(this.topics);

                while (true)
                {
                    var consumeResult = consumer.Consume();
                    Console.WriteLine("############### ONE ###############");
                    Console.WriteLine($"Message: {consumeResult.Message.Value}\nTopic: {consumeResult.Topic}\nGroupId: { this.config.GroupId};");
                    Console.WriteLine(Environment.NewLine);
                }

                // consumer.Close();
            }
        }
    }
}