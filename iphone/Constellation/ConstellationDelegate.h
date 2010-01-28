
@class Constellation;
@protocol ConstellationDelegate
@optional
- (BOOL)constellationShouldGetForums:(Constellation *)constellation;
- (void)constellationDidGetForums:(NSData *)data;

- (BOOL)constellationShouldGetTopics:(Constellation *)constellation forForum:(NSString *)forum;
- (void)constellationDidGetTopics:(NSData *)data;

- (BOOL)constellationShouldGetMessages:(Constellation *)constellation forTopic:(NSString *)topic;
- (void)constellationDidGetMessages:(NSData *)data;
@end