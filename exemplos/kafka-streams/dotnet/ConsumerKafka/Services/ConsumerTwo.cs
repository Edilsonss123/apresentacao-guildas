using Confluent.Kafka;
using System.Net;

namespace ConsumerKafka
{
    class ConsumerTwo
    {
        string[] topics;
        ConsumerConfig config;
        public ConsumerTwo()
        {
            Console.WriteLine("Consumer two");
            this.config = new ConsumerConfig
            {
                BootstrapServers = "kafka:9092",
                GroupId = "group-teste-1",
                AutoOffsetReset = AutoOffsetReset.Earliest
            };

            this.topics = new string[1] {"teste"};
        }

        public void Execute()
        {
            Console.WriteLine("Tô esperando mensagens two");

            using (var consumer = new ConsumerBuilder<Ignore, string>(config).Build())
            {
                consumer.Subscribe(this.topics);

                while (true)
                {
                    var consumeResult = consumer.Consume();
                    Console.WriteLine("############### TWO ###############");
                    Console.WriteLine($"Message: {consumeResult.Message.Value}\nTopic: {consumeResult.Topic}\nGroupId: { this.config.GroupId};");
                    Console.WriteLine(Environment.NewLine);
                }

                // consumer.Close();
            }
        }
    }
}